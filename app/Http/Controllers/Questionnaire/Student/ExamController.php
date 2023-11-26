<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\StudentFacade;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    protected StudentFacade $studentFacade;

    public function __construct()
    {
        $this->studentFacade = new StudentFacade();
    }

    public function listAssessments(Request $request, Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        if (!Gate::allows('open-course', $course)) {
            abort(403);
        }
        $data = [
            'course' => $course->load('assessments'),
        ];

        return view('questionnaire.student.course', $data);
    }

    public function listModules(Course $course, Assessment $assessment): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'course' => $course,
            'assessment' => $assessment->loadCount(['questions']),
            'modules' => Module::getWithMetaInfo($assessment),
        ];
        $data['modulesCount'] = collect($data['modules'])->count();
        $data['questionsCount'] = collect($data['modules'])->sum(fn ($module) => $module['questionCount']);

        return view('questionnaire.student.assessment', $data);
    }

    public function listQuestions(Course $course, Assessment $assessment, Module $module)
    {
        $questions = $this->studentFacade->populateQuestions($module);
        $this->studentFacade->startSession($module, $questions);
        $data = [
            'course' => $course,
            'assessment' => $assessment,
            'module' => $module,
            'exam' => $this->studentFacade->startExam($module),
            'questions' => $questions,
        ];

        return view('questionnaire.student.module', $data);
    }

    public function openQuestion(Course $course, Assessment $assessment, Module $module, Question $question, Exam $exam)
    {
        $data = $question->type
            ->getStudentServiceObject()
            ->getViewData($course, $assessment, $module, $question, $exam);

        return view('questionnaire.student.question', $data);
    }

    public function submitAnswer(
        Course     $course,
        Assessment $assessment,
        Module     $module,
        Question   $question,
        Exam       $exam,
        Request    $request
    ) {
        try {
            $typeService = $question->type->getStudentServiceObject();
            $answerData = AnswerData::from($typeService->validated($request));
            ['result' => $result, 'msg' => $msg] = $typeService->submitAnswer($question, $answerData)->checkResult();

            if ($nextQuestion = $this->studentFacade->getNextQuestion($module, $question)) {
                $nextQuestion = route('student.openQuestion', [$course, $assessment, $module, $nextQuestion['id'], $exam]);
            }

            return response()->json(['msg' => $msg, 'result' => $result, 'nextQuestion' => $nextQuestion]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}

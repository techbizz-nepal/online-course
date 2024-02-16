<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\StudentFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function __construct(protected StudentFacade $studentFacade)
    {

    }

    public function listModules(Course $course)
    {
        if (! Gate::allows('open-course', $course)) {
            abort(403);
        }
        $data = [
            'course' => $course,
            'modules' => Module::query()
                ->select(['id', 'name', 'fullMark', 'passMark', 'slug'])
                ->with(['exams' => function ($q) {
                    $q->byStudentID(Auth::guard('student')->id())->with('examQuestion');
                }])
                ->withCount('questions')
                ->get()
                ->each(function (Module $module) {
                    $module->mutateWithScoreStatus();
                }),
        ];
        $data['modulesCount'] = collect($data['modules'])->count();
        $data['questionsCount'] = collect($data['modules'])->sum(fn ($module) => $module->questions_count);

        return view('questionnaire.student.course', $data);
    }

    public function listQuestions(Course $course, Module $module)
    {
        $exam = $this->studentFacade->startExam($module);
        $questions = $this->studentFacade->getMappedQuestionsWithAnswers($module, $exam);
        $this->studentFacade->startSession($module, $questions);
        $data = [
            'course' => $course,
            'module' => $module,
            'exam' => $exam,
            'questions' => $questions,
        ];

        return view('questionnaire.student.module', $data);
    }

    public function openQuestion(Course $course, Module $module, Question $question, Exam $exam)
    {
        $data = $question->type
            ->getStudentServiceObject()
            ->getViewData($course, $module, $question, $exam);

        return view('questionnaire.student.question', $data);
    }

    public function submitAnswer(
        Course $course,
        Module $module,
        Question $question,
        Exam $exam,
        Request $request
    ) {
        try {
            $typeService = $question->type->getStudentServiceObject();
            $answerData = AnswerData::from($typeService->validated($request));
            ['result' => $result, 'msg' => $msg] = $typeService->submitAnswer($question, $answerData)->checkResult();

            if ($nextQuestion = $this->studentFacade->getNextQuestion($module, $question)) {
                $nextQuestion = route('student.openQuestion', [$course, $module, $nextQuestion['id'], $exam]);
            }

            return response()->json(['msg' => $msg, 'result' => $result, 'nextQuestion' => $nextQuestion]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), ['data' => $request->all()]);

            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}

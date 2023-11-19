<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Services\Student\InterfaceStudent;
use App\Questionnaire\StudentFacade;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function listAssessments(Request $request, Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'course' => $course->load('assessments'),
        ];

        return view('questionnaire.student.course', $data);
    }

    public function listModules(Course $course, Assessment $assessment)
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
        $facade = new StudentFacade();
        $questions = $facade->populateQuestions($module);
        $facade->startSession($module, $questions);
        $data = [
            'course' => $course,
            'assessment' => $assessment,
            'module' => $module,
            'exam' => $facade->startExam($module),
            'questions' => $questions,
        ];

        return view('questionnaire.student.module', $data);
    }

    public function openQuestion(Course $course, Assessment $assessment, Module $module, Question $question, Exam $exam)
    {
        $data = self::getStudentService($question)->getViewData($course, $assessment, $module, $question, $exam);

        return view('questionnaire.student.question', $data);
    }

    public function submitAnswer(
        Course $course,
        Assessment $assessment,
        Module $module,
        Question $question,
        Exam $exam,
        Request $request
    ) {
        try {
            $typeService = self::getStudentService($question);
            $studentFacade = new StudentFacade();
            $answerData = AnswerData::from($typeService->validated($request));
            ['result' => $result, 'msg' => $msg] = $typeService->submitAnswer($question, $answerData)->checkResult();
            $nextQuestion = $studentFacade->getNextQuestion($module, $question);
            if ($nextQuestion) {
                $nextQuestion = route('student.openQuestion', [$course, $assessment, $module, $nextQuestion['id'], $exam]);
            }

            return response()->json(['msg' => $msg, 'result' => $result, 'nextQuestion' => $nextQuestion]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    private static function getStudentService(Question $question): InterfaceStudent
    {
        return QuestionType::from($question->getAttribute('type'))->getStudentServiceObject();
    }
}

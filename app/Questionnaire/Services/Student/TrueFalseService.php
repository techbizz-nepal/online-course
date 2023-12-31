<?php

namespace App\Questionnaire\Services\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Http\Request;

class TrueFalseService extends BaseStudent implements InterfaceStudent
{
    public const RELATION_NAME = 'trueFalse';

    public const VIEW_PATH = 'questionnaire.student.type.true-false';

    public function validated(Request $request): array
    {
        return $request->validate([
            'answer' => ['required', 'string'],
            'exam_id' => ['required', 'string'],
            'question_id' => ['required', 'string'],
        ]);
    }

    public function getViewData(Course $course, Assessment $assessment, Module $module, Question $question, Exam $exam): array
    {
        return [
            'viewPath' => self::VIEW_PATH,
            'course' => $course,
            'assessment' => $assessment,
            'module' => $module,
            'exam' => $exam,
            'question' => $question->load([self::RELATION_NAME]),
        ];
    }

    public function submitAnswer(Question $question, AnswerData $answerData): InterfaceStudent
    {
        $this->answerData = $answerData; // initialize answer data
        $this->question = $question; // initialize question data

        return $this->submit();
    }

    public function checkResult(): array
    {
        if ($this->getResult(self::RELATION_NAME)) {
            return ['result' => true, 'msg' => 'Your answer is correct'];
        } else {
            return ['result' => false, 'msg' => 'Your answer is incorrect'];
        }
    }
}

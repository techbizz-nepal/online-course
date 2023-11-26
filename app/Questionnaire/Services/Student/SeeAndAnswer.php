<?php

namespace App\Questionnaire\Services\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Http\Request;

class SeeAndAnswer implements InterfaceStudent
{
    public function validated(Request $request): array
    {
        // TODO: Implement validated() method.
    }

    public function getViewData(Course $course, Assessment $assessment, Module $module, Question $question, Exam $exam): array
    {
        // TODO: Implement getViewData() method.
    }

    public function submitAnswer(Question $question, AnswerData $answerData): InterfaceStudent
    {
        // TODO: Implement submitAnswer() method.
    }

    public function checkResult(): array
    {
        // TODO: Implement checkResult() method.
    }
}

<?php

namespace App\Questionnaire\Services\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Models\Course;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Http\Request;

interface InterfaceStudent
{
    public function validated(Request $request): array;

    public function getViewData(Course $course, Module $module, Question $question, Exam $exam): array;

    public function submitAnswer(Question $question, AnswerData $answerData): InterfaceStudent;

    public function checkResult(): array;
}

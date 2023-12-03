<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionReadAndAnswerRepo
{
    public function create(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model;

    public function update(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model;

    public function prepare(array $questionsArray): QuestionReadAndAnswerData;
}

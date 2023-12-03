<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionTrueFalseRepo
{
    public function create(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model;

    public function update(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model;

    public function prepare(int $correctAnswer): QuestionTrueFalseData;
}

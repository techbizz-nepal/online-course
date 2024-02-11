<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionMultipleChoiceData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionMultipleChoiceRepo
{
    public function create(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData): Model;

    public function update(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData): Model;

    public function prepare(array $choices): QuestionMultipleChoiceData;
}

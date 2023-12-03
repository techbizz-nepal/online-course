<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionClosedOptionRepo
{
    public function create(Question $question, QuestionOptionData $questionOptionData): Model;

    public function update(Question $question, QuestionOptionData $questionOptionData): Model;

    public function prepare(array $options, string $answer): QuestionOptionData;
}

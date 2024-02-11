<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionMultipleChoiceData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionMultipleChoiceRepo implements InterfaceQuestionMultipleChoiceRepo
{
    public function create(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData): Model
    {
        return $question->multipleChoice()->create($questionMultipleChoiceData->toArray());
    }

    public function update(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData): Model
    {
        return $question->multipleChoice()->updateOrCreate(['question_id' => $question->id], $questionMultipleChoiceData->toArray());
    }

    public function prepare(array $choices): QuestionMultipleChoiceData
    {
        return QuestionMultipleChoiceData::from([
            'body' => $choices,
        ]);
    }
}

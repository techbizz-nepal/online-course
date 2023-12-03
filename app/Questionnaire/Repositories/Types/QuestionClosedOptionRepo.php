<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionClosedOptionRepo implements InterfaceQuestionClosedOptionRepo
{
    public function create(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $question->option()->create($questionOptionData->toArray());
    }

    public function update(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $question->option()->updateOrCreate(['question_id' => $question->id], $questionOptionData->toArray());
    }

    public function prepare(array $options, string $answer): QuestionOptionData
    {
        return QuestionOptionData::from([
            'body' => $options,
            'answer' => $answer,
        ]);
    }
}

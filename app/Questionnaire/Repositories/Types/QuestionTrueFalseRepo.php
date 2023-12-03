<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionTrueFalseRepo implements InterfaceQuestionTrueFalseRepo
{
    public function create(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $question->trueFalse()->create($questionTrueFalseData->toArray());
    }

    public function update(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $question->trueFalse()->updateOrCreate(['question_id' => $question->id], $questionTrueFalseData->toArray());
    }

    public function prepare(int $correctAnswer): QuestionTrueFalseData
    {
        return QuestionTrueFalseData::from([
            'answer' => $correctAnswer,
        ]);
    }
}

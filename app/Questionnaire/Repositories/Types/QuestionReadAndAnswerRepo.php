<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuestionReadAndAnswerRepo implements InterfaceQuestionReadAndAnswerRepo
{
    public function create(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $question->readAndAnswer()->create($questionReadAndAnswerData->toArray());
    }

    public function update(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $question->readAndAnswer()->updateOrCreate(['question_id' => $question->id], $questionReadAndAnswerData->toArray());
    }

    public function prepare(array $questionsArray): QuestionReadAndAnswerData
    {
        $questionsWithKeys = [];
        foreach ($questionsArray['questions'] as $question) {
            $questionsWithKeys[] = ['id' => Str::uuid(), 'value' => $question];
        }

        return QuestionReadAndAnswerData::from(['questions' => $questionsWithKeys]);
    }
}

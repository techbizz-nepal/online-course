<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionSeeAndAnswerRepo implements InterfaceQuestionSeeAndAnswerRepo
{
    public function create(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model
    {
        return $question->seeAndAnswer()->create($questionSeeAndAnswerData->toArray());
    }

    public function update(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model
    {
        return $question->seeAndAnswer()->updateOrCreate(['question_id' => $question->id], $questionSeeAndAnswerData->toArray());
    }
}

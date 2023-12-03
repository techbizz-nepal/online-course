<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionSeeAndAnswerRepo
{
    public function create(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model;
    public function update(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model;
}

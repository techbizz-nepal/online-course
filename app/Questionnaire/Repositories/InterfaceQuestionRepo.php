<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\QuestionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionRepo
{
    public function create(Module $module, QuestionData $questionData): Model;

    public function update(Question $question, QuestionData $questionData): Model;
}

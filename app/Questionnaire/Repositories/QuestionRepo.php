<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\QuestionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionRepo extends BaseRepo implements InterfaceQuestionRepo
{
    public function create(Module $module, QuestionData $questionData): Model
    {
        return $module->questions()->create($questionData->toArray());
    }

    public function update(Question $question, QuestionData $questionData): Model
    {
        $question->update($questionData->toArray());

        return $question;
    }
}

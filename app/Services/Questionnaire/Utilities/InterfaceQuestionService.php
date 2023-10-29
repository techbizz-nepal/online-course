<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionService
{
    public function create(Module $module, QuestionData $questionData): Model;

    public function createOption(Question $question, array $row): Model;

    public function createOptions(Question $question, QuestionOptionData $questionOptionData): Collection;
}

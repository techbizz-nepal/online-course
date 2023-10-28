<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface InterfaceQuestionService
{
    public function create(Module $module, QuestionData $questionData): Model;

    public function createOptions(Question $question, QuestionOptionData $questionOptionData): HasMany;
}

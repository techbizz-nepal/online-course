<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InterfaceQuestionService
{
    public function create(Module $module, QuestionData $questionData): Model;

    function update(Question $question, QuestionData $questionData): Model;

    public function createOption(Question $question, QuestionOptionData $questionOptionData): Model;

    public function updateOption(Question $question, QuestionOptionData $questionOptionData): Model;

    function prepareOptions(array $options, string|null $correctAnswer): QuestionOptionData;
}

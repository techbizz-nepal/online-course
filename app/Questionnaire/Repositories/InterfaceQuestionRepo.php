<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceQuestionRepo
{
    public function create(Module $module, QuestionData $questionData): Model;

    public function update(Question $question, QuestionData $questionData): Model;

    public function createOption(Question $question, QuestionOptionData $questionOptionData): Model;

    public function createTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model;

    public function createDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model;

    public function createReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model;

    public function updateOption(Question $question, QuestionOptionData $questionOptionData): Model;

    public function updateReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model;

    public function updateDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model;

    public function updateTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model;

    public function prepareOptions(array $options, string $answer): QuestionOptionData;

    public function prepareTrueFalse(int $correctAnswer): QuestionTrueFalseData;

    public function prepareReadAndAnswer(array $questionsArray): QuestionReadAndAnswerData;

    public function uploadDescribeImageMaterial(Request $request, Module $module): array;

    public function deleteDescribeImageMaterial(Question $question): bool;
}

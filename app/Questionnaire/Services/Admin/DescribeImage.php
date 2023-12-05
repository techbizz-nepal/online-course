<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DescribeImage implements InterfaceAdmin
{
    use HasImage;

    public const TYPE = QuestionType::DESCRIBE_IMAGE;

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }

    public function validated(Request $request): array
    {
        return $request->validate([
            'image_path' => ['string', 'required'],
            'questions' => ['array', 'required'],
            'questions.*.id' => ['string', 'required'],
            'questions.*.body' => ['string', 'required'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionDescribeImageData = QuestionDescribeImageData::from($validated);

        return QuestionnaireAdmin::createQuestionDescribeImage($question, $questionDescribeImageData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $questionDescribeImageData = QuestionDescribeImageData::from($validated);

        return QuestionnaireAdmin::updateQuestionDescribeImage($question, $questionDescribeImageData);
    }

    public function deleteProcess(Question $question): void
    {
        $question->describeImage()->delete();
        $question->delete();
    }
}

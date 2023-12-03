<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeeAndAnswerAdmin implements InterfaceAdmin
{
    use HasImage;

    public const TYPE = QuestionType::SEE_AND_ANSWER;

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }

    public function validated(Request $request): array
    {
        return $request->validate([
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string'],
            'items.*.image_path' => ['required', 'string'],
            'items.*.id' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionReadAndAnswerData = QuestionSeeAndAnswerData::from($validated);

        return QuestionnaireAdmin::createQuestionSeeAndAnswer($question, $questionReadAndAnswerData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $questionSeeAndAnswerData = QuestionSeeAndAnswerData::from($validated);

        return QuestionnaireAdmin::updateQuestionSeeAndAnswer($question, $questionSeeAndAnswerData);
    }

    public function deleteProcess(Question $question): void
    {
        // TODO: Implement deleteProcess() method.
    }
}

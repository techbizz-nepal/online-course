<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MultipleChoiceAdmin implements InterfaceAdmin
{
    use HasImage;

    public const TYPE = QuestionType::MULTIPLE_CHOICE;

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }

    public function validated(Request $request): array
    {
        return $request->validate([
            'choices' => ['required', 'array'],
            'choices.*.id' => ['required', 'string'],
            'choices.*.value' => ['required', 'string'],
            'choices.*.checked' => ['string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $choices = $validated['choices'];
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $answers = QuestionnaireAdmin::prepareQuestionMultipleChoice($choices);

        return QuestionnaireAdmin::createQuestionMultipleChoice($question, $answers);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        $choices = $validated['choices'];
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $answers = QuestionnaireAdmin::prepareQuestionMultipleChoice($choices);

        return QuestionnaireAdmin::updateQuestionMultipleChoice($question, $answers);
    }

    public function deleteProcess(Question $question): void
    {
        $question->{self::TYPE->relation()}()->delete();
        $question->delete();
    }
}

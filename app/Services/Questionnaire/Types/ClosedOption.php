<?php

namespace App\Services\Questionnaire\Types;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ClosedOption extends BaseType implements InterfaceType
{
    public const TYPE = QuestionType::CLOSE_ENDED_OPTIONS;

    public function validated(Request $request): array
    {
        return $request->validate([
            'option1' => ['required', 'string'],
            'option2' => ['required', 'string'],
            'option3' => ['required', 'string'],
            'option4' => ['required', 'string'],
            'is_correct' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'is_correct');
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $options = QuestionnaireAdmin::prepareQuestionOptions($validated, $correctAnswer);

        return QuestionnaireAdmin::createQuestionOption($question, $options);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'is_correct');
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $options = QuestionnaireAdmin::prepareQuestionOptions($validated, $correctAnswer);

        return QuestionnaireAdmin::updateQuestionOption($question, $options);
    }

    public function deleteProcess(Question $question): void
    {
        $question->option()->delete();
        $question->delete();
    }

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }
}

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

class TrueFalse extends BaseType implements InterfaceType
{
    public const TYPE = QuestionType::TRUE_FALSE;

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }

    public function validated(Request $request): array
    {
        return $request->validate([
            'is_true' => ['boolean', 'required'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'is_true');
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionTrueFalseData = QuestionnaireAdmin::prepareQuestionTrueFalse($validated, $correctAnswer);

        return QuestionnaireAdmin::createQuestionTrueFalse($question, $questionTrueFalseData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'is_true');
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $options = QuestionnaireAdmin::prepareQuestionTrueFalse($validated, $correctAnswer);

        return QuestionnaireAdmin::updateQuestionTrueFalse($question, $options);
    }

    public function deleteProcess(Question $question): void
    {
        $question->trueFalse()->delete();
        $question->delete();
    }
}

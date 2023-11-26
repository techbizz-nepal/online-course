<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TrueFalseAdmin implements InterfaceAdmin
{
    public const TYPE = QuestionType::TRUE_FALSE;

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }

    public function validated(Request $request): array
    {
        return $request->validate([
            'answer' => ['boolean', 'required'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'answer');
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionTrueFalseData = QuestionnaireAdmin::prepareQuestionTrueFalse($correctAnswer);

        return QuestionnaireAdmin::createQuestionTrueFalse($question, $questionTrueFalseData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        $correctAnswer = Arr::pull($validated, 'answer');
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $trueFalseData = QuestionnaireAdmin::prepareQuestionTrueFalse($correctAnswer);

        return QuestionnaireAdmin::updateQuestionTrueFalse($question, $trueFalseData);
    }

    public function deleteProcess(Question $question): void
    {
        $question->trueFalse()->delete();
        $question->delete();
    }
}

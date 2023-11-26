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

class ClosedOptionAdmin implements InterfaceAdmin
{
    public const TYPE = QuestionType::CLOSE_ENDED_OPTIONS;

    public function validated(Request $request): array
    {
        return $request->validate([
            'option1' => ['required', 'string'],
            'option2' => ['required', 'string'],
            'option3' => ['required', 'string'],
            'option4' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $answer = Arr::pull($validated, 'answer');
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $options = QuestionnaireAdmin::prepareQuestionOptions($validated, $answer);

        return QuestionnaireAdmin::createQuestionOption($question, $options);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        $answer = Arr::pull($validated, 'answer');
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $options = QuestionnaireAdmin::prepareQuestionOptions($validated, $answer);

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

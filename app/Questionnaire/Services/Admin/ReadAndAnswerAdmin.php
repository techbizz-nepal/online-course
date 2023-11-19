<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReadAndAnswerAdmin extends BaseAdmin implements InterfaceAdmin
{
    public const TYPE = QuestionType::READ_AND_ANSWER;

    public function validated(Request $request): array
    {
        return $request->validate([
            'questions' => ['required', 'array'],
            'questions.*' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionReadAndAnswerData = QuestionnaireAdmin::prepareQuestionReadAndAnswer($validated);

        return QuestionnaireAdmin::createQuestionReadAndAnswer($question, $questionReadAndAnswerData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $questionReadAndAnswerData = QuestionnaireAdmin::prepareQuestionReadAndAnswer($validated);

        return QuestionnaireAdmin::updateQuestionReadAndAnswer($question, $questionReadAndAnswerData);
    }

    public function deleteProcess(Question $question): void
    {
        $question->readAndAnswer()->delete();
        $question->delete();
    }

    public function getTypeValue(): string
    {
        return self::TYPE->value;
    }
}

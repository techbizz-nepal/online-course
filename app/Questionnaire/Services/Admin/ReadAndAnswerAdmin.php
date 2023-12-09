<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReadAndAnswerAdmin implements InterfaceAdmin
{
    public const TYPE = QuestionType::READ_AND_ANSWER;

    public function validated(Request $request): array
    {
        return $request->validate([
            'questions' => ['array', 'required'],
            'questions.*.id' => ['string', 'required'],
            'questions.*.body' => ['string', 'required'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
        $questionReadAndAnswerData = QuestionReadAndAnswerData::from($validated);

        return QuestionnaireAdmin::createQuestionReadAndAnswer($question, $questionReadAndAnswerData);
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        QuestionnaireAdmin::updateQuestion($question, $questionData);
        $questionReadAndAnswerData = QuestionReadAndAnswerData::from($validated);

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

<?php

namespace App\Services\Questionnaire\Types;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReadAndAnswer extends BaseType implements InterfaceType
{
    public const TYPE = QuestionType::READ_AND_ANSWER;

    public function validated(Request $request): array
    {
        return $request->validate([
            'questions.*' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        return tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        return QuestionnaireAdmin::updateQuestion($question, $questionData);
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

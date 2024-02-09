<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
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
            'options' => ['required', 'array'],
            'options.*.id' => ['required', 'string'],
            'options.*.value' => ['required', 'string'],
        ]);
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {

    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {

    }

    public function deleteProcess(Question $question): void
    {
        $question->{self::TYPE->relation()}()->delete();
        $question->delete();
    }
}

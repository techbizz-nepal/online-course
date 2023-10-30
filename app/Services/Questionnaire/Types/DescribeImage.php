<?php

namespace App\Services\Questionnaire\Types;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DescribeImage extends BaseType implements InterfaceType
{
    public function validated(Request $request): array
    {
        return ['describe image'];
    }

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model
    {
        // TODO: Implement storeProcess() method.
    }

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model
    {
        // TODO: Implement updateProcess() method.
    }

    public function deleteProcess(Question $question): void
    {
        // TODO: Implement deleteProcess() method.
    }

    public function getTypeValue(): string
    {
        return QuestionType::DESCRIBE_IMAGE->value;
    }
}

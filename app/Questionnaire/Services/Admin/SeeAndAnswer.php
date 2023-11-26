<?php

namespace App\Questionnaire\Services\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeeAndAnswer implements InterfaceAdmin
{
    public function getTypeValue(): string
    {
        // TODO: Implement getTypeValue() method.
    }

    public function validated(Request $request): array
    {
        // TODO: Implement validated() method.
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
}

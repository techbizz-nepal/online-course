<?php

namespace App\Services\Questionnaire\Types;

use App\DTO\Questionnaire\QuestionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceType
{
    public function getTypeValue(): string;

    public function validated(Request $request): array;

    public function storeProcess(array $validated, Module $module, QuestionData $questionData): Model;

    public function updateProcess(array $validated, Question $question, QuestionData $questionData): Model;

    public function deleteProcess(Question $question): void;
}

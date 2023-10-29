<?php

namespace App\Services\Questionnaire\Utilities;


use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class QuestionService implements InterfaceQuestionService
{

    public function create(Module $module, QuestionData $questionData): Model
    {
        return $module->questions()->create($questionData->toArray());
    }

    public function createOption(Question $question, array $row): Model
    {
        return $question->options()->create($row);
    }

    public function createOptions(Question $question, QuestionOptionData $questionOptionData): Collection
    {
        Arr::map($questionOptionData->toArray(), function ($value, $key) use ($questionOptionData, $question) {
            if ($questionOptionData->isCorrect === $key) {
                $row = ["body" => $value, "is_correct" => true];
            } else {
                $row = ["body" => $value];
            }
            if (Str::contains($key, "option")) $this->createOption($question, $row);
            return $value;
        });
        return $question->options()->get();
    }
}

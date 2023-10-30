<?php

namespace App\Services\Questionnaire\Utilities;


use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionService implements InterfaceQuestionService
{

    public function create(Module $module, QuestionData $questionData): Model
    {
        return $module->questions()->create($questionData->toArray());
    }

    public function update(Question $question, QuestionData $questionData): Model
    {
        $question->update($questionData->toArray());
        return $question;
    }

    public function createOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $question->option()->create($questionOptionData->toArray());
    }

    public function updateOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        $question->option()->update($questionOptionData->toArray());
        return $question;
    }

    public function prepareOptions(array $options, string|null $correctAnswer): QuestionOptionData
    {
        return QuestionOptionData::from([
            "body" => $options,
            "is_correct" => $correctAnswer
        ]);
    }
}

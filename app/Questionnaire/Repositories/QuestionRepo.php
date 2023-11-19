<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Models\Questionnaire\QuestionTrueFalse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionRepo extends BaseRepo implements InterfaceQuestionRepo
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

    public function createDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $question->describeImage()->create($questionDescribeImageData->toArray());
    }

    public function createTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $question->trueFalse()->create($questionTrueFalseData->toArray());
    }

    public function createReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $question->readAndAnswer()->create($questionReadAndAnswerData->toArray());
    }

    public function updateOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $question->option()->updateOrCreate(['question_id' => $question->id], $questionOptionData->toArray());
    }

    public function updateReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $question->readAndAnswer()->updateOrCreate(['question_id' => $question->id], $questionReadAndAnswerData->toArray());
    }

    public function updateDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $question->describeImage()->updateOrCreate(['question_id' => $question->id], $questionDescribeImageData->toArray());
    }

    public function updateTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $question->trueFalse()->updateOrCreate(['question_id' => $question->id], $questionTrueFalseData->toArray());
    }

    public function prepareOptions(array $options, string $answer): QuestionOptionData
    {
        return QuestionOptionData::from([
            'body' => $options,
            'answer' => $answer,
        ]);
    }

    public function prepareTrueFalse(int $correctAnswer): QuestionTrueFalseData
    {
        return QuestionTrueFalseData::from([
            'answer' => $correctAnswer,
        ]);
    }

    public function prepareReadAndAnswer(array $questionsArray): QuestionReadAndAnswerData
    {
        $questionsWithKeys = [];
        foreach ($questionsArray['questions'] as $question) {
            $questionsWithKeys[] = ['id' => Str::uuid(), 'value' => $question];
        }

        return QuestionReadAndAnswerData::from(['questions' => $questionsWithKeys]);
    }

    public function uploadDescribeImageMaterial(Request $request, Module $module): array
    {
        $data = $request->validate([
            'image_path' => 'file|mimetypes:image/*',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/',
        ]);

        return $this->storeImageProcess(
            slug: $module->getAttribute('slug'),
            systemPath: QuestionDescribeImageData::SYSTEM_PATH,
            data: $data
        );
    }

    public function deleteDescribeImageMaterial(Question $question): bool
    {
        return $this->deleteImageProcess(
            model: $question,
            systemPath: QuestionDescribeImageData::SYSTEM_PATH
        );
    }
}

<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestionService extends BaseService implements InterfaceQuestionService
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
        $builder = $question->option();
        $builder->update($questionOptionData->toArray());

        return $builder->first();
    }

    public function updateReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        $builder = $question->readAndAnswer();
        $builder->update($questionReadAndAnswerData->toArray());

        return $builder->first();
    }

    public function updateDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        $builder = $question->describeImage();
        $builder->update($questionDescribeImageData->toArray());

        return $builder->first();
    }

    public function updateTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        $builder = $question->trueFalse();
        $builder->update($questionTrueFalseData->toArray());

        return $builder->first();
    }

    public function prepareOptions(array $options, string $correctAnswer): QuestionOptionData
    {
        return QuestionOptionData::from([
            'body' => $options,
            'is_correct' => $correctAnswer,
        ]);
    }

    public function prepareTrueFalse(array $options, bool $correctAnswer): QuestionTrueFalseData
    {
        return QuestionTrueFalseData::from([
            'is_true' => $correctAnswer,
        ]);
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

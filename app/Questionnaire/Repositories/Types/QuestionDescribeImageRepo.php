<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionDescribeImageRepo implements InterfaceQuestionDescribeImageRepo
{
    public function create(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $question->describeImage()->create($questionDescribeImageData->toArray());
    }

    public function update(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $question->describeImage()->updateOrCreate(['question_id' => $question->id], $questionDescribeImageData->toArray());
    }
}

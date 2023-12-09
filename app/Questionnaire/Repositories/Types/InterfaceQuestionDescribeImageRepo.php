<?php

namespace App\Questionnaire\Repositories\Types;

use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;

interface InterfaceQuestionDescribeImageRepo
{
    public function create(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model;

    public function update(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model;
}

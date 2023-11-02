<?php

namespace Database\Seeders;

use App\Models\Questionnaire\QuestionDescribeImage;
use Illuminate\Database\Seeder;

class QuestionDescribeImageSeeder extends Seeder
{
    const TABLE_NAME = 'question_describe_images';

    public function __construct(private QuestionDescribeImage $model)
    {
        $this->model = new QuestionDescribeImage();
    }

    public function run(): void
    {
        $this->model->factory()->count(1)->create();
    }
}

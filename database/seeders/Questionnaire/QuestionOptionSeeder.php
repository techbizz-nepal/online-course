<?php

namespace Database\Seeders\Questionnaire;

use App\Models\Questionnaire\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionOptionSeeder extends Seeder
{
    const TABLE_NAME = 'questionnaire_question_options';

    public function __construct(private QuestionOption $model)
    {
        $this->model = new QuestionOption();
    }

    public function run(): void
    {
        $this->model->factory()->count(100)->create();
    }
}

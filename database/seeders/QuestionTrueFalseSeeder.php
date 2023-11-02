<?php

namespace Database\Seeders;

use App\Models\Questionnaire\QuestionTrueFalse;
use Illuminate\Database\Seeder;

class QuestionTrueFalseSeeder extends Seeder
{
    const TABLE_NAME = 'question_true_falses';

    public function __construct(private QuestionTrueFalse $model)
    {
        $this->model = new QuestionTrueFalse();
    }

    public function run(): void
    {
        $this->model->factory()->count(100)->create();
    }
}

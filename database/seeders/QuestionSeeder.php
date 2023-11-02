<?php

namespace Database\Seeders;

use App\Models\Questionnaire\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    const TABLE_NAME = 'questions';

    public function __construct(private Question $model)
    {
        $this->model = new Question();
    }

    public function run(): void
    {
        $this->model->factory()->count(200)->create();
    }
}

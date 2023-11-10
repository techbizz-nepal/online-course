<?php

namespace Database\Seeders\Questionnaire;

use App\Models\Questionnaire\QuestionReadAndAnswer;
use Illuminate\Database\Seeder;

class QuestionReadAndAnswerSeeder extends Seeder
{
    public const TABLE_NAME = 'questionnaire_question_read_and_answers';

    public function __construct(private QuestionReadAndAnswer $model)
    {
        $this->model = new QuestionReadAndAnswer();
    }

    public function run(): void
    {
        $this->model->factory()->count(100)->create();
    }
}

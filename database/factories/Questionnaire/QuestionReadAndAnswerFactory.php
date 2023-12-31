<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\Models\Questionnaire\Question;
use App\Models\Questionnaire\QuestionDescribeImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends Factory<QuestionDescribeImage>
 */
class QuestionReadAndAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomQuestionId = Arr::random(Question::query()->select(['id'])->pluck('id')->toArray(), '1')[0];

        return QuestionReadAndAnswerData::from([
            'question_id' => $randomQuestionId,
            'questions' => [
                ['id' => Str::uuid(), 'body' => $this->faker->paragraph],
                ['id' => Str::uuid(), 'body' => $this->faker->paragraph],
                ['id' => Str::uuid(), 'body' => $this->faker->paragraph],
                ['id' => Str::uuid(), 'body' => $this->faker->paragraph],
            ],
        ])->toArray();
    }
}

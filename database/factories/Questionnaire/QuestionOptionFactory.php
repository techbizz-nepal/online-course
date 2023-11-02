<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionnaire\QuestionOption>
 */
class QuestionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomQuestionId = Arr::random(Question::query()->select(['id'])->pluck('id')->toArray(), '1')[0];

        $body = [
            'option1' => $this->faker->paragraph(1),
            'option2' => $this->faker->paragraph(1),
            'option3' => $this->faker->paragraph(1),
            'option4' => $this->faker->paragraph(1),
        ];
        $is_correct = array_rand($body, 1);

        return QuestionOptionData::from([
            'question_id' => $randomQuestionId,
            'body' => $body,
            'is_correct' => $is_correct,
        ])->toArray();
    }
}

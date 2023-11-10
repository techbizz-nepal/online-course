<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Questionnaire\Question;
use App\Models\Questionnaire\QuestionTrueFalse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<QuestionTrueFalse>
 */
class QuestionTrueFalseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomQuestionId = Arr::random(Question::query()->select(['id'])->pluck('id')->toArray(), '1')[0];

        return QuestionTrueFalseData::from([
            'answer' => $this->faker->boolean,
            'question_id' => $randomQuestionId,
        ])->toArray();
    }
}

<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomType = Arr::random(QuestionType::toArray());
        $randomModuleId = Arr::random(Module::query()->select(['id'])->pluck('id')->toArray(), '1')[0];

        return QuestionData::from([
            'module_id' => $randomModuleId,
            'body' => $this->faker->paragraph,
            'order' => $this->faker->randomDigitNotZero(),
            'type' => $randomType,
        ])->toArray();
    }
}

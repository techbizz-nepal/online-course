<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = AssessmentData::from(['name'=> $this->faker->name, 'course_id'=> $this->faker->randomDigit()]);
        return $data->toArray();
    }
}

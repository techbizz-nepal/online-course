<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $randomCourseId = Arr::random(Course::query()->select(['id'])->pluck('id')->toArray(), '1')[0];
        $data = AssessmentData::from([
            'name' => $this->faker->name,
            'course_id' => $randomCourseId,
            'description' => $this->faker->paragraph,
            'material' => 'riiwhs205e-control-traffic-with-a-stop-slow-bat-thamelmartcom-ZMh6GVoY92a3yKx1.pdf',
        ]);

        return $data->toArray();
    }
}

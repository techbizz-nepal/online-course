<?php

namespace Database\Factories\Questionnaire;

use App\DTO\Questionnaire\ModuleData;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomAssessmentId = Arr::random(Assessment::query()->select(['id'])->pluck('id')->toArray(), '1')[0];
        $data = ModuleData::from([
            'name' => $this->faker->name,
            'assessment_id' => $randomAssessmentId,
            'description' => $this->faker->paragraph,
            'material' => 'riiwhs205e-control-traffic-with-a-stop-slow-bat-thamelmartcom-ZMh6GVoY92a3yKx1.pdf',
        ]);

        return $data->toArray();
    }
}

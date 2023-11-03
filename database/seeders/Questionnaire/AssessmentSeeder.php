<?php

namespace Database\Seeders\Questionnaire;

use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AssessmentSeeder extends Seeder
{
    const TABLE_NAME = 'questionnaire_assessments';

    public function __construct(private Assessment $model)
    {
        $this->model = new Assessment();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rowsFromJson = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), self::TABLE_NAME);

        if (! $rowsFromJson) {
            $this->model->factory()->count(200)->create();
        }
        if (! $this->model->query()->count() && $rowsFromJson) {
            Arr::map($rowsFromJson['data'], function ($row) {
                DB::table(self::TABLE_NAME)->insert($row);
            });
        }
    }
}

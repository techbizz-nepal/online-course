<?php

namespace Database\Seeders\Questionnaire;

use App\Models\Questionnaire\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModuleSeeder extends Seeder
{
    public const TABLE_NAME = 'questionnaire_modules';

    public function __construct(private Module $model = new Module())
    {
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

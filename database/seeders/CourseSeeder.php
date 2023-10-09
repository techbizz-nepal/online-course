<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/courses.json'))[2]["data"];
        if (!Course::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("courses")->insert($row);
            });
        }
    }
}

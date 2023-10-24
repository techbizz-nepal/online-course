<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), 'students')['data'];
        if (!Student::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("students")->insert($row);
            });
        }
    }
}

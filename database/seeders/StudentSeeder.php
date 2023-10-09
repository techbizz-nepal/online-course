<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $rows = File::json(database_path('data/students.json'))[2]["data"];

        if (!Student::query()->count() && $rows) {

            Arr::map($rows, function ($row) {

                $rowToAppend = [
                    'username' => Str::slug($row['name']),
                    'email' => fake()->email,
                    'email_verified_at' => null,
                    'password' => bcrypt('password'),
                    'remember_token' => null
                ];

                $row = $row + $rowToAppend;
                $duplicate = DB::table("students")->where('username', '=', $rowToAppend['username'])->count();
                if (!$duplicate) {
                    DB::table("students")->insert($row);
                }
            });
        }
    }
}

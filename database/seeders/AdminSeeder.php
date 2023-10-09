<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $rows = File::json(database_path('data/users.json'))[2]["data"];
        if (!User::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("users")->insert($row);
            });
        }
    }
}

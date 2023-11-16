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
        $rows = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), 'users')['data'];
        if (!User::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table('users')->insert($row);
            });
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/pages.json'))[2]["data"];
        if (!Page::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("pages")->insert($row);
            });
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/categories.json'))[2]["data"];
        if (!Category::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("categories")->insert($row);
            });
        }
    }
}

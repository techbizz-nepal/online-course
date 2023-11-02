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
     */
    public function run(): void
    {
        $rows = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), 'categories')['data'];
        if (! Category::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table('categories')->insert($row);
            });
        }
    }
}

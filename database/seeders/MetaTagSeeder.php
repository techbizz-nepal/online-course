<?php

namespace Database\Seeders;

use App\Models\MetaTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MetaTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/meta_tags.json'))[2]["data"];
        if (!MetaTag::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("meta_tags")->insert($row);
            });
        }
    }
}

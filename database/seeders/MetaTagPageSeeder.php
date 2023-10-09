<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MetaTagPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/meta_tag_page.json'))[2]["data"];
        if (!DB::table('meta_tag_page')->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("meta_tag_page")->insert($row);
            });
        }
    }
}

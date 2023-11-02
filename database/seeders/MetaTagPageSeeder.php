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
        $rows = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), 'meta_tag_page')['data'];
        if (! DB::table('meta_tag_page')->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table('meta_tag_page')->insert($row);
            });
        }
    }
}

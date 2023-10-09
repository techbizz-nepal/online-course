<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/banners.json'))[2]["data"];
        if (!Banner::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("banners")->insert($row);
            });
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\BookingDate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BookingDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = File::json(database_path('data/booking_dates.json'))[2]["data"];
        if (!BookingDate::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("booking_dates")->insert($row);
            });
        }
    }
}

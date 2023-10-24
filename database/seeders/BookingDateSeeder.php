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
        $rows = Arr::get(Arr::keyBy(File::json(database_path('data/keyeduau_muhamad.json')), 'name'), 'booking_dates')['data'];
        if (!BookingDate::query()->count() && $rows) {
            Arr::map($rows, function ($row) {
                DB::table("booking_dates")->insert($row);
            });
        }
    }
}

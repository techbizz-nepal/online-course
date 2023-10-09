<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            StudentSeeder::class,
            BannerSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            PagesSeeder::class,
            MetaTagSeeder::class,
            MetaTagPageSeeder::class,
            BookingDateSeeder::class
        ]);
    }
}

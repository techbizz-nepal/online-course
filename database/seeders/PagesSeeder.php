<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = Page::all();

        if (count($pages) === 0){

            Page::create([
                'name' => 'Home',
                'slug' => 'home'
            ]);

            Page::create([
                'name' => 'Contact',
                'slug' => 'contact'
            ]);

            Page::create([
                'name' => 'About',
                'slug' => 'about'
            ]);
            $courses = Course::all();
            foreach ($courses as $course){
                Page::create([
                    'name' => $course->title,
                    'slug' => $course->slug,
                    'is_course' => true,
                    'course_id' => $course->id
                ]);
            }

        }
    }
}

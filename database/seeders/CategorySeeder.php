<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::orderBy('display_order')->get();
        $count = 0;
        foreach ($courses as $course){
            $category = Category::create([
                'name' => $course->title,
                'image' => $course->image,
                'slug' => $course->slug,
                'display_order' => $count,
            ]);
            $count = $count + 1;
            $course->update([
               'category_id' => $category->id
            ]);
        }
    }
}

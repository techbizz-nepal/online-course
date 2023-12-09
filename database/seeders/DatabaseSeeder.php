<?php

namespace Database\Seeders;

use Database\Seeders\Questionnaire\AssessmentSeeder;
use Database\Seeders\Questionnaire\ModuleSeeder;
use Database\Seeders\Questionnaire\QuestionDescribeImageSeeder;
use Database\Seeders\Questionnaire\QuestionOptionSeeder;
use Database\Seeders\Questionnaire\QuestionReadAndAnswerSeeder;
use Database\Seeders\Questionnaire\QuestionSeeder;
use Database\Seeders\Questionnaire\QuestionTrueFalseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            BookingDateSeeder::class,
            //            AssessmentSeeder::class,
            //            ModuleSeeder::class,
            //            QuestionSeeder::class,
            //            QuestionTrueFalseSeeder::class,
            //            QuestionOptionSeeder::class,
            //            QuestionReadAndAnswerSeeder::class,
            //            QuestionDescribeImageSeeder::class,
        ]);
    }
}

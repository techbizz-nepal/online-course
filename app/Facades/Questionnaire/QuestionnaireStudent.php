<?php

namespace App\Facades\Questionnaire;

use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection getAssessmentsByStudent(Course $course)
 * @method static float|int calculatePercentage(Assessment $assessment)
 */
class QuestionnaireStudent extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'student-facade';
    }
}

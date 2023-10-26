<?php

namespace App\Facades\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Model createCourseAssessment(AssessmentData $assessmentData, Course $course) Add a new course assessment
 * @method static int updateCourseAssessment(AssessmentData $assessmentData, Course $course) Add a new course assessment
 * @method static array uploadCourseAssessmentMaterial(Request $request, Course $course) Upload course assessment material
 * @method static void deleteCourseAssessmentMaterial(Assessment $assessment) delete course assessment material
 * @method static bool checkIfAssessmentSlugExists(AssessmentData $assessmentData) check if assessment slug exists
 */
class QuestionnaireAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'admin-service';
    }
}

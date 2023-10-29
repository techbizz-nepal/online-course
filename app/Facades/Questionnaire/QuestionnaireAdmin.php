<?php

namespace App\Facades\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\DTO\Questionnaire\ModuleData;
use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Model createCourseAssessment(AssessmentData $assessmentData, Course $course) Add a new course assessment
 * @method static Model createCourseAssessmentModule(ModuleData $assessmentData, Course $course, Assessment $assessment) Add a new assessment module
 * @method static int updateCourseAssessment(Course $course, AssessmentData $assessmentData) update course assessment
 * @method static int updateCourseAssessmentModule(Assessment $assessment, ModuleData $moduleData) update assessment module
 * @method static array uploadCourseAssessmentMaterial(Request $request, Course $course) Upload course assessment material
 * @method static array uploadCourseAssessmentModuleMaterial(Request $request, Assessment $assessment) Upload course assessment module material
 * @method static bool deleteCourseAssessmentMaterial(Assessment $assessment) delete course assessment material
 * @method static bool deleteCourseAssessmentModuleMaterial(Module $module) delete course assessment material
 * @method static string getNewIfAssessmentSlugExists(AssessmentData $assessmentData, Assessment $assessment) check if assessment slug exists
 * @method static string getNewIfModuleSlugExists(ModuleData $moduleData, Module $module) check if module slug exists
 * @method static Model createQuestion(Module $module, QuestionData $questionData) create question
 * @method static Collection createQuestionOptions(Question $question, QuestionOptionData $questionOptionData) create question options
 */
class QuestionnaireAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'admin-service';
    }
}

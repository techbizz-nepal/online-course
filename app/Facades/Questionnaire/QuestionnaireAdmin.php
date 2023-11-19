<?php

namespace App\Facades\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\DTO\Questionnaire\ModuleData;
use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Model createCourseAssessment(AssessmentData $assessmentData, Course $course) Add a new course assessment
 * @method static Model createCourseAssessmentModule(ModuleData $assessmentData, Course $course, Assessment $assessment) Add a new assessment module
 * @method static Model createQuestion(Module $module, QuestionData $questionData) create question
 * @method static Model createQuestionOption(Question $question, QuestionOptionData $questionOptionData) create one question to one option
 * @method static Model createQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData) create one question to one true false
 * @method static Model createQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData) create one question to one read and answer
 * @method static Model createQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData) create one question to one describe image
 * @method static int updateCourseAssessment(Course $course, AssessmentData $assessmentData) update course assessment
 * @method static int updateCourseAssessmentModule(Assessment $assessment, ModuleData $moduleData) update assessment module
 * @method static int updateQuestion(Question $question, QuestionData $questionData) update question
 * @method static Model updateQuestionOption(Question $question, QuestionOptionData $questionOptionData) update one question to one option
 * @method static Model updateQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData) update one question to one true false
 * @method static Model updateQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData) update one question to one read and answer
 * @method static Model updateQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData) update one question to one describe image
 * @method static string getNewIfAssessmentSlugExists(AssessmentData $assessmentData, Assessment $assessment) check if assessment slug exists
 * @method static string getNewIfModuleSlugExists(ModuleData $moduleData, Module $module) check if module slug exists
 * @method static QuestionOptionData prepareQuestionOptions(array $options, string|null $correctAnswer) prepare question option for create many
 * @method static QuestionTrueFalseData prepareQuestionTrueFalse(int $correctAnswer) prepare question true false for create many
 * @method static QuestionReadAndAnswerData prepareQuestionReadAndAnswer(array $questionsArray) prepare question read and answer for create one
 * @method static array uploadAssessmentMaterial(Request $request, Course $course) Upload course assessment material
 * @method static array uploadModuleMaterial(Request $request, Assessment $assessment) Upload course assessment module material
 * @method static array uploadQuestionMaterial(Request $request, Module $question) Upload course assessment module question material
 * @method static bool deleteAssessmentMaterial(Assessment $assessment) delete course assessment material
 * @method static bool deleteModuleMaterial(Module $module) delete course assessment material
 * @method static bool deleteQuestionMaterial(Question $question) delete course assessment material
 */
class QuestionnaireAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'admin-facade';
    }
}

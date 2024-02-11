<?php

namespace App\Facades\Questionnaire;

use App\DTO\Questionnaire\ModuleData;
use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionMultipleChoiceData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Course;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Model createCourseModule(ModuleData $assessmentData, Course $course)
 * @method static Model createQuestion(Module $module, QuestionData $questionData)
 * @method static Model createQuestionOption(Question $question, QuestionOptionData $questionOptionData)
 * @method static Model createQuestionMultipleChoice(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData)
 * @method static Model createQuestionSeeAndAnswer(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswer)
 * @method static Model createQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData)
 * @method static Model createQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData)
 * @method static Model createQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData)
 * @method static int updateCourseModule(Course $course, ModuleData $moduleData)
 * @method static int updateQuestion(Question $question, QuestionData $questionData)
 * @method static Model updateQuestionOption(Question $question, QuestionOptionData $questionOptionData)
 * @method static Model updateQuestionMultipleChoice(Question $question, QuestionMultipleChoiceData $questionMultipleChoiceData)
 * @method static Model updateQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData)
 * @method static Model updateQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData)
 * @method static Model updateQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData)
 * @method static Model updateQuestionSeeAndAnswer(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData)
 * @method static string getNewIfModuleSlugExists(ModuleData $moduleData, Module $module)
 * @method static QuestionOptionData prepareQuestionOptions(array $choices, string|null $correctAnswer)
 * @method static QuestionMultipleChoiceData prepareQuestionMultipleChoice(array $choices)
 * @method static QuestionTrueFalseData prepareQuestionTrueFalse(int $correctAnswer)
 * @method static QuestionReadAndAnswerData prepareQuestionReadAndAnswer(array $questionsArray)
 * @method static array uploadModuleMaterial(Request $request, Course $course)
 * @method static bool deleteModuleMaterial(Module $module)
 */
class QuestionnaireAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'admin-facade';
    }
}

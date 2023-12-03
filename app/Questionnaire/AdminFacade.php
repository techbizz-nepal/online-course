<?php

namespace App\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\DTO\Questionnaire\ModuleData;
use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionReadAndAnswerData;
use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Repositories\InterfaceAssessmentRepo;
use App\Questionnaire\Repositories\InterfaceModuleRepo;
use App\Questionnaire\Repositories\InterfaceQuestionRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionClosedOptionRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionDescribeImageRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionReadAndAnswerRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionSeeAndAnswerRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionTrueFalseRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final readonly class AdminFacade
{
    public function __construct(
        private InterfaceAssessmentRepo $assessmentRepo,
        private InterfaceModuleRepo $moduleRepo,
        private InterfaceQuestionRepo $questionRepo,
        private InterfaceQuestionClosedOptionRepo $questionClosedOptionRepo,
        private InterfaceQuestionDescribeImageRepo $questionDescribeImageRepo,
        private InterfaceQuestionSeeAndAnswerRepo $questionSeeAndAnswerRepo,
        private InterfaceQuestionTrueFalseRepo $questionTrueFalseRepo,
        private InterfaceQuestionReadAndAnswerRepo $questionReadAndAnswerRepo,
    ) {
    }

    public function createCourseAssessment(AssessmentData $assessmentData, Course $course): Model
    {
        return $this->assessmentRepo->create($assessmentData, $course);
    }

    public function updateCourseAssessment(Course $course, AssessmentData $assessmentData): int
    {
        return $this->assessmentRepo->update($course, $assessmentData);
    }

    public function deleteAssessmentMaterial(Assessment $assessment): bool
    {
        return $this->assessmentRepo->deleteMaterial($assessment);
    }

    public function uploadAssessmentMaterial(Request $request, Course $course): array
    {
        return $this->assessmentRepo->uploadMaterial($request, $course);
    }

    public function getNewIfAssessmentSlugExists(AssessmentData $assessmentData, Assessment $assessment): string
    {
        return $this->assessmentRepo->getOrGenerateSlug($assessmentData, $assessment);
    }

    public function createCourseAssessmentModule(ModuleData $moduleData, Course $course, Assessment $assessment): Model
    {
        return $this->moduleRepo->create($moduleData, $assessment);
    }

    public function updateCourseAssessmentModule(Assessment $assessment, ModuleData $moduleData): int
    {
        return $this->moduleRepo->update($assessment, $moduleData);
    }

    public function deleteModuleMaterial(Module $module): bool
    {
        return $this->moduleRepo->deleteMaterial($module);
    }

    public function uploadModuleMaterial(Request $request, Assessment $assessment): array
    {
        return $this->moduleRepo->uploadMaterial($request, $assessment);
    }

    public function getNewIfModuleSlugExists(ModuleData $moduleData, Module $module): string
    {
        return $this->moduleRepo->getOrGenerateSlug($moduleData, $module);
    }

    public function createQuestion(Module $module, QuestionData $questionData): Model
    {
        return $this->questionRepo->create($module, $questionData);
    }

    public function updateQuestion(Question $question, QuestionData $questionData): Model
    {
        return $this->questionRepo->update($question, $questionData);
    }

    /***************************** type repo methods started ***************************/
    public function prepareQuestionOptions(array $options, ?string $answer): QuestionOptionData
    {
        return $this->questionClosedOptionRepo->prepare($options, $answer);
    }

    public function prepareQuestionTrueFalse(int $correctAnswer): QuestionTrueFalseData
    {
        return $this->questionTrueFalseRepo->prepare($correctAnswer);
    }

    public function prepareQuestionReadAndAnswer(array $questions): QuestionReadAndAnswerData
    {
        return $this->questionReadAndAnswerRepo->prepare($questions);
    }

    public function createQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionClosedOptionRepo->create($question, $questionOptionData);
    }

    public function createQuestionSeeAndAnswer(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model
    {
        return $this->questionSeeAndAnswerRepo->create($question, $questionSeeAndAnswerData);
    }

    public function createQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $this->questionTrueFalseRepo->create($question, $questionTrueFalseData);
    }

    public function createQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionDescribeImageRepo->create($question, $questionDescribeImageData);
    }

    public function createQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionReadAndAnswerRepo->create($question, $questionReadAndAnswerData);
    }

    public function updateQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionClosedOptionRepo->update($question, $questionOptionData);
    }

    public function updateQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $this->questionTrueFalseRepo->update($question, $questionTrueFalseData);
    }

    public function updateQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionDescribeImageRepo->update($question, $questionDescribeImageData);
    }

    public function updateQuestionSeeAndAnswer(Question $question, QuestionSeeAndAnswerData $questionSeeAndAnswerData): Model
    {
        return $this->questionSeeAndAnswerRepo->update($question, $questionSeeAndAnswerData);
    }

    public function updateQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionReadAndAnswerRepo->update($question, $questionReadAndAnswerData);
    }
}

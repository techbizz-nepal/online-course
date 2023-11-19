<?php

namespace App\Questionnaire;

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
use App\Questionnaire\Repositories\InterfaceAssessmentRepo;
use App\Questionnaire\Repositories\InterfaceModuleRepo;
use App\Questionnaire\Repositories\InterfaceQuestionRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final readonly class AdminFacade
{
    public function __construct(
        private InterfaceAssessmentRepo $assessmentRepo,
        private InterfaceModuleRepo $moduleRepo,
        private InterfaceQuestionRepo $questionRepo
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

    public function uploadQuestionMaterial(Request $request, Module $module): array
    {
        return $this->questionRepo->uploadDescribeImageMaterial($request, $module);
    }

    public function deleteQuestionMaterial(Question $question): bool
    {
        return $this->questionRepo->deleteDescribeImageMaterial($question);
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

    public function prepareQuestionOptions(array $options, ?string $answer): QuestionOptionData
    {
        return $this->questionRepo->prepareOptions($options, $answer);
    }

    public function prepareQuestionTrueFalse(int $correctAnswer): QuestionTrueFalseData
    {
        return $this->questionRepo->prepareTrueFalse($correctAnswer);
    }

    public function prepareQuestionReadAndAnswer(array $questions): QuestionReadAndAnswerData
    {
        return $this->questionRepo->prepareReadAndAnswer($questions);
    }

    public function createQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionRepo->createOption($question, $questionOptionData);
    }

    public function createQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $this->questionRepo->createTrueFalse($question, $questionTrueFalseData);
    }

    public function createQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionRepo->createDescribeImage($question, $questionDescribeImageData);
    }

    public function createQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionRepo->createReadAndAnswer($question, $questionReadAndAnswerData);
    }

    public function updateQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionRepo->updateOption($question, $questionOptionData);
    }

    public function updateQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $this->questionRepo->updateTrueFalse($question, $questionTrueFalseData);
    }

    public function updateQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionRepo->updateDescribeImage($question, $questionDescribeImageData);
    }

    public function updateQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionRepo->updateReadAndAnswer($question, $questionReadAndAnswerData);
    }
}

<?php

namespace App\Services\Questionnaire;

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
use App\Services\Questionnaire\Utilities\InterfaceAssessmentService;
use App\Services\Questionnaire\Utilities\InterfaceModuleService;
use App\Services\Questionnaire\Utilities\InterfaceQuestionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final readonly class AdminService
{
    public function __construct(
        private InterfaceAssessmentService $assessmentService,
        private InterfaceModuleService $moduleService,
        private InterfaceQuestionService $questionService
    ) {
    }

    public function createCourseAssessment(AssessmentData $assessmentData, Course $course): Model
    {
        return $this->assessmentService->create($assessmentData, $course);
    }

    public function updateCourseAssessment(Course $course, AssessmentData $assessmentData): int
    {
        return $this->assessmentService->update($course, $assessmentData);
    }

    public function deleteAssessmentMaterial(Assessment $assessment): bool
    {
        return $this->assessmentService->deleteMaterial($assessment);
    }

    public function uploadAssessmentMaterial(Request $request, Course $course): array
    {
        return $this->assessmentService->uploadMaterial($request, $course);
    }

    public function getNewIfAssessmentSlugExists(AssessmentData $assessmentData, Assessment $assessment): string
    {
        return $this->assessmentService->getOrGenerateSlug($assessmentData, $assessment);
    }

    public function createCourseAssessmentModule(ModuleData $moduleData, Course $course, Assessment $assessment): Model
    {
        return $this->moduleService->create($moduleData, $assessment);
    }

    public function updateCourseAssessmentModule(Assessment $assessment, ModuleData $moduleData): int
    {
        return $this->moduleService->update($assessment, $moduleData);
    }

    public function deleteModuleMaterial(Module $module): bool
    {
        return $this->moduleService->deleteMaterial($module);
    }

    public function uploadModuleMaterial(Request $request, Assessment $assessment): array
    {
        return $this->moduleService->uploadMaterial($request, $assessment);
    }

    public function uploadQuestionMaterial(Request $request, Module $module): array
    {
        return $this->questionService->uploadDescribeImageMaterial($request, $module);
    }

    public function deleteQuestionMaterial(Question $question): bool
    {
        return $this->questionService->deleteDescribeImageMaterial($question);
    }

    public function getNewIfModuleSlugExists(ModuleData $moduleData, Module $module): string
    {
        return $this->moduleService->getOrGenerateSlug($moduleData, $module);
    }

    public function createQuestion(Module $module, QuestionData $questionData): Model
    {
        return $this->questionService->create($module, $questionData);
    }

    public function updateQuestion(Question $question, QuestionData $questionData): Model
    {
        return $this->questionService->update($question, $questionData);
    }

    public function prepareQuestionOptions(array $options, ?string $correctAnswer): QuestionOptionData
    {
        return $this->questionService->prepareOptions($options, $correctAnswer);
    }

    public function prepareQuestionTrueFalse(array $options, ?string $correctAnswer): QuestionTrueFalseData
    {
        return $this->questionService->prepareTrueFalse($options, $correctAnswer);
    }

    public function createQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionService->createOption($question, $questionOptionData);
    }

    public function createQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        return $this->questionService->createTrueFalse($question, $questionTrueFalseData);
    }

    public function createQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionService->createDescribeImage($question, $questionDescribeImageData);
    }

    public function createQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionService->createReadAndAnswer($question, $questionReadAndAnswerData);
    }

    public function updateQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionService->updateOption($question, $questionOptionData);
    }

    public function updateQuestionTrueFalse(Question $question, QuestionTrueFalseData $questionTrueFalseData): Model
    {
        $update = $this->questionService->updateTrueFalse($question, $questionTrueFalseData);
        Log::info('while updating: ', [$update->toArray()]);

        return $update;
    }

    public function updateQuestionDescribeImage(Question $question, QuestionDescribeImageData $questionDescribeImageData): Model
    {
        return $this->questionService->updateDescribeImage($question, $questionDescribeImageData);
    }

    public function updateQuestionReadAndAnswer(Question $question, QuestionReadAndAnswerData $questionReadAndAnswerData): Model
    {
        return $this->questionService->updateReadAndAnswer($question, $questionReadAndAnswerData);
    }
}

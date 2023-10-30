<?php

namespace App\Services\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\DTO\Questionnaire\ModuleData;
use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Services\Questionnaire\Utilities\InterfaceAssessmentService;
use App\Services\Questionnaire\Utilities\InterfaceModuleService;
use App\Services\Questionnaire\Utilities\InterfaceQuestionService;
use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final readonly class AdminService
{
    public function __construct(
        private InterfaceAssessmentService $assessmentService,
        private InterfaceModuleService     $moduleService,
        private InterfaceQuestionService   $questionService
    )
    {
    }

    public function createCourseAssessment(AssessmentData $assessmentData, Course $course): Model
    {
        return $this->assessmentService->create($assessmentData, $course);
    }

    public function updateCourseAssessment(Course $course, AssessmentData $assessmentData): int
    {
        return $this->assessmentService->update($course, $assessmentData);
    }

    public function deleteCourseAssessmentMaterial(Assessment $assessment): bool
    {
        return $this->assessmentService->deleteMaterial($assessment);
    }

    public function uploadCourseAssessmentMaterial(Request $request, Course $course): array
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

    public function deleteCourseAssessmentModuleMaterial(Module $module): bool
    {
        return $this->moduleService->deleteMaterial($module);
    }

    public function uploadCourseAssessmentModuleMaterial(Request $request, Assessment $assessment): array
    {
        return $this->moduleService->uploadMaterial($request, $assessment);
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

    public function prepareQuestionOptions(array $options, string|null $correctAnswer): QuestionOptionData
    {
        return $this->questionService->prepareOptions($options, $correctAnswer);
    }

    public function createQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionService->createOption($question, $questionOptionData);
    }

    public function updateQuestionOption(Question $question, QuestionOptionData $questionOptionData): Model
    {
        return $this->questionService->updateOption($question, $questionOptionData);
    }
}

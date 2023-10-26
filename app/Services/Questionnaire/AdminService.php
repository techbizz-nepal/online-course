<?php

namespace App\Services\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\DTO\Questionnaire\ModuleData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final readonly class AdminService
{
    public function createCourseAssessment(AssessmentData $assessmentData, Course $course): Model
    {
        return $course->assessments()->create($assessmentData->toArray());
    }

    public function createCourseAssessmentModule(ModuleData $moduleData, Course $course, Assessment $assessment): Model
    {
        return $assessment->modules()->create($moduleData->toArray());
    }

    public function updateCourseAssessment(AssessmentData $assessmentData, Course $course): int
    {
        return $course->assessments()->update($assessmentData->toArray());
    }

    public function uploadCourseAssessmentMaterial(Request $request, Course $course): array
    {
        return $this->storeProcess(
            request: $request,
            slug: $course->getAttribute('slug'),
            systemPath: AssessmentData::SYSTEM_PATH);
    }

    public function uploadCourseAssessmentModuleMaterial(Request $request, Assessment $assessment): array
    {
        return $this->storeProcess(
            request: $request,
            slug: $assessment->getAttribute('slug'),
            systemPath: ModuleData::SYSTEM_PATH);
    }

    public function deleteCourseAssessmentMaterial(Assessment $assessment): void
    {
        $this->deleteProcess(model: $assessment, systemPath: AssessmentData::SYSTEM_PATH);
    }

    public function deleteCourseAssessmentModuleMaterial(Module $module): void
    {
        $this->deleteProcess(model: $module, systemPath: ModuleData::SYSTEM_PATH);
    }

    public function checkIfAssessmentSlugExists(AssessmentData $assessmentData): bool
    {
        return Assessment::query()->where('slug', $assessmentData->slug)->exists();
    }

    public function checkIfModuleSlugExists(ModuleData $moduleData): bool
    {
        return Module::query()->where('slug', $moduleData->slug)->exists();
    }

    private function storeProcess(Request $request, string $slug, string $systemPath): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:10000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/'
        ]);
        ['name' => $name, 'pdfFile' => $pdf] = $data;
        $pdfName = sprintf('%s-%s-%s.%s', $slug, Str::slug($name), Str::random(), $pdf->extension());
        $pdf->move(storage_path($systemPath), $pdfName);
        return ['fileName' => $pdfName];
    }

    private function deleteProcess(Model $model, string $systemPath): void
    {
        $filePath = sprintf('%s/%s', $systemPath, $model->getAttribute('material'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }
    }
}

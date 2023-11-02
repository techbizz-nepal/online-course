<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssessmentService extends BaseService implements InterfaceAssessmentService
{
    public function create(AssessmentData $assessmentData, Course $course): Model
    {
        return $course->assessments()->create($assessmentData->toArray());
    }

    public function update(Course $course, AssessmentData $assessmentData): int
    {
        return $course->assessments()->update($assessmentData->toArray());
    }

    public function uploadMaterial(Request $request, Course $course): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:10000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/',
        ]);

        return $this->storeProcess(
            data: $data,
            slug: $course->getAttribute('slug'),
            systemPath: AssessmentData::SYSTEM_PATH);
    }

    public function deleteMaterial(Assessment $assessment): bool
    {
        return $this->deleteProcess(model: $assessment, systemPath: AssessmentData::SYSTEM_PATH);
    }

    public function getOrGenerateSlug(AssessmentData $assessmentData, Assessment $assessment): string
    {
        return $assessment->query()->where('slug', $assessmentData->slug)->exists()
            ? sprintf('%s-%s', $assessmentData->slug, Str::random(10))
            : $assessmentData->slug;
    }
}

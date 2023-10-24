<?php

namespace App\Services\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final readonly class AdminService
{
    public function createCourseAssessment(AssessmentData $assessmentData, Course $course): Model
    {
        return $course->assessments()->create($assessmentData->toArray());
    }

    public function updateCourseAssessment(AssessmentData $assessmentData, Course $course): int
    {
        return $course->assessments()->update($assessmentData->toArray());
    }

    public function uploadCourseAssessmentMaterial(Request $request, Course $course): array
    {
        $data = $request->validate([
            'pdfFile' => 'file|mimetypes:application/pdf|max:10000',
            'name' => 'required|regex:/[A-Za-z0-9_-]+/'
        ]);
        ['name' => $name, 'pdfFile' => $pdf] = $data;
        $pdfName = sprintf('%s-%s-%s.%s', $course->getAttribute('slug'), Str::slug($name), Str::random(), $pdf->extension());
        $pdf->move(storage_path(AssessmentData::SYSTEM_PATH), $pdfName);
        return ['fileName' => $pdfName];
    }

    public function deleteCourseAssessmentMaterial(Assessment $assessment): void
    {
        $filePath = sprintf('%s/%s', AssessmentData::SYSTEM_PATH, $assessment->getAttribute('material'));
        if (File::exists(storage_path($filePath))) {
            File::delete(storage_path($filePath));
        }
    }
}

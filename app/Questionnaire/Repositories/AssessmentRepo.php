<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssessmentRepo extends BaseRepo implements InterfaceAssessmentRepo
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
            slug: $course->getAttribute('slug'),
            systemPath: AssessmentData::SYSTEM_PATH,
            data: $data
        );
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

    public function getAssessmentsByStudent(Course $course): Collection
    {
        return Assessment::with('modules.questions.answers')
        ->where('course_id', $course->getAttribute('id'))
        ->get();
    }

    public function calculatePercentage(Assessment $assessment): float|int
    {
        $totalQuestions = $assessment->modules->flatMap(function ($module) {
            return $module->questions;
        })->count();

        $answeredQuestions = $assessment->modules->flatMap(function ($module) {
            return $module->questions->flatMap(function ($question) {
                return $question->answers;
            });
        })->count();

        return ($answeredQuestions / $totalQuestions) * 100;
    }
}

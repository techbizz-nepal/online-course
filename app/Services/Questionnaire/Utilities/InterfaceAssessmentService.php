<?php

namespace App\Services\Questionnaire\Utilities;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceAssessmentService
{
    public function create(AssessmentData $assessmentData, Course $course): Model;

    public function update(Course $course, AssessmentData $assessmentData): int;

    public function uploadMaterial(Request $request, Course $course): array;

    public function deleteMaterial(Assessment $assessment): bool;

    public function getOrGenerateSlug(AssessmentData $assessmentData, Assessment $assessment): string;
}

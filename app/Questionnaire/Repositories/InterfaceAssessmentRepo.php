<?php

namespace App\Questionnaire\Repositories;

use App\DTO\Questionnaire\AssessmentData;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InterfaceAssessmentRepo
{
    public function create(AssessmentData $assessmentData, Course $course): Model;

    public function update(Course $course, AssessmentData $assessmentData): int;

    public function uploadMaterial(Request $request, Course $course): array;

    public function deleteMaterial(Assessment $assessment): bool;

    public function getOrGenerateSlug(AssessmentData $assessmentData, Assessment $assessment): string;

    public function getAssessmentsByStudent(Course $course): Collection;

    public function calculatePercentage(Assessment $assessment): float|int;
}

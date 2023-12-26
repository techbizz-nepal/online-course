<?php

namespace App\Traits;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Course;
use App\Models\Questionnaire\Module;
use Illuminate\Support\Arr;

trait HasAttributeRepository
{
    private function getModuleShowAttributes(Course $course, Module $module): array
    {
        return [
            'course' => $course,
            'module' => $module->load(['questions']),
            'questionTypes' => Arr::map(QuestionType::cases(), function ($case) {
                return ['type' => $case->value, 'label' => QuestionType::from($case->value)->value()];
            }),
        ];
    }

    private function getAssessmentShowAttributes(Course $course, $assessment): array
    {
        return [
            'course' => $course->load(['modules']),
            'questionTypes' => Arr::map(QuestionType::cases(), function ($case) {
                return ['type' => $case->value, 'label' => QuestionType::from($case->value)->value()];
            }),
        ];
    }
}

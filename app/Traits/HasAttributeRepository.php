<?php

namespace App\Traits;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait HasAttributeRepository
{
    private function getModuleShowAttributes(Course $course, Assessment $assessment, Module $module): array
    {
        return [
            'course' => $course,
            'assessment' => $assessment,
            'module' => $module->load(['questions']),
            'questionTypes' => Arr::map(QuestionType::cases(), function ($case) {
                return ['type' => $case->value, "label" => QuestionType::from($case->value)->value()];
            })
        ];
    }
    private function getAssessmentShowAttributes(Course $course, Assessment $assessment): array
    {
        return [
            'course' => $course,
            'assessment' => $assessment->load(['modules']),
            'questionTypes' => Arr::map(QuestionType::cases(), function ($case) {
                return ['type' => $case->value, "label" => QuestionType::from($case->value)->value()];
            })
        ];
    }
}

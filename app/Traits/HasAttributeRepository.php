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
    private function getQuestionEditAttributes(Course $course, Assessment $assessment, Module $module, Question $question): array
    {
        return [
            "course" => $course,
            "assessment" => $assessment,
            "module" => $module,
            "question" => $question->load('options'),
            "types" =>
                [
                    "closeOption" => QuestionType::CLOSE_ENDED_OPTIONS->value,
                    "readAndAnswer" => QuestionType::READ_AND_ANSWER->value,
                    "describeImage" => QuestionType::DESCRIBE_IMAGE->value
                ]
        ];
    }

    private function getQuestionCreateAttributes(Request $request, Course $course, Assessment $assessment, Module $module): array
    {
        return [
            "question" =>
                [
                    "requestType" => in_array($request->get('questionType'), QuestionType::toArray())
                        ? $request->get('questionType')
                        : QuestionType::CLOSE_ENDED_OPTIONS->value,
                    "types" =>
                        [
                            "closeOption" => QuestionType::CLOSE_ENDED_OPTIONS->value,
                            "readAndAnswer" => QuestionType::READ_AND_ANSWER->value,
                            "describeImage" => QuestionType::DESCRIBE_IMAGE->value
                        ]
                ],
            "course" => $course,
            "assessment" => $assessment,
            "module" => $module
        ];
    }
}

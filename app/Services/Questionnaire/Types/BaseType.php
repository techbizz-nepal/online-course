<?php

namespace App\Services\Questionnaire\Types;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Http\Request;

abstract class BaseType
{
    public function getQuestionCreateAttributes(Request $request, Course $course, Assessment $assessment, Module $module): array
    {
        return [
            "question" =>
                [
                    "type" => in_array($request->get('type'), QuestionType::toArray())
                        ? $request->get('type')
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
            "module" => $module,
            "routeParams" => [
                "course" => $course->getAttribute('slug'),
                "assessment" => $assessment->getAttribute('slug'),
                "module" => $module->getAttribute('slug'),
                "type" => $request->get('type')
            ]
        ];
    }

    public function getQuestionEditAttributes(Course $course, Assessment $assessment, Module $module, Question $question): array
    {
        return [
            "course" => $course,
            "assessment" => $assessment,
            "module" => $module,
            "question" => $question->load('option'),
            "types" =>
                [
                    "closeOption" => QuestionType::CLOSE_ENDED_OPTIONS->value,
                    "readAndAnswer" => QuestionType::READ_AND_ANSWER->value,
                    "describeImage" => QuestionType::DESCRIBE_IMAGE->value
                ],
            "routeParams" => [
                "course" => $course->getAttribute('slug'),
                "assessment" => $assessment->getAttribute('slug'),
                "module" => $module->getAttribute('slug'),
                "question" => $question->getAttribute("id"),
                "type" => $question->getAttribute('type')
            ]
        ];
    }
}
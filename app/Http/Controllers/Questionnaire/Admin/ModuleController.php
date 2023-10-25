<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;

class ModuleController extends Controller
{
    public function create(Course $course, Assessment $assessment)
    {
        $routeParams = ["course" => $course->getAttribute('slug'), "assessment" => $assessment->getAttribute('slug')];
        $html = '<h1>create module</h1>';
        $html .= '<a href=' . route('admin.courses.assessments.show', $routeParams) . '>Go Back</a>';
        return $html;
    }

    public function show(Course $course, Assessment $assessment, Module $module)
    {
        return [$module];
    }

    public function edit(Course $course, Assessment $assessment, Module $module)
    {
        return [$module];
    }

    public function destroy(Course $course, Assessment $assessment, Module $module)
    {
        return [$module];
    }
}

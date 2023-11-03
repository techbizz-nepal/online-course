<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function listAssessments(Request $request, Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'course' => $course->load('assessments'),
        ];

        return view('questionnaire.student.course', $data);
    }

    public function listModules(Course $course, Assessment $assessment)
    {
        $data = [
            'course' => $course,
            'assessment' => $assessment
                ->load(['modules' => function ($q) {
                    return $q->withCount('questions');
                }])
                ->loadCount('modules')
                ->loadCount('questions'),
        ];

        return view('questionnaire.student.assessment', $data);
    }

    public function listQuestions(Course $course, Assessment $assessment, Module $module)
    {
        $data = [
            'course' => $course,
            'assessment' => $assessment,
            'module' => $module->load('questions'),
        ];
        Exam::query()->firstOrCreate([
            'module_id' => $module->id,
            'student_id' => Auth::guard('student')->id(),
        ]);

        return view('questionnaire.student.module', $data);
    }
}

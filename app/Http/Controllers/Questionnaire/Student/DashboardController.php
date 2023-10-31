<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'student' => Student::query()->with('courses')->find(Auth::id())
        ];
        return view('questionnaire.student.index', $data);
    }

    public function courseCover(Request $request, Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'course' => $course->load('assessments')
        ];
        return view('questionnaire.student.course', $data);
    }

    public function startExam(Course $course, Assessment $assessment)
    {
        $data = [
            'course' => $course,
            'assessment' => $assessment->load('modules')
        ];
        return view('questionnaire.student.assessment', $data);
    }
}

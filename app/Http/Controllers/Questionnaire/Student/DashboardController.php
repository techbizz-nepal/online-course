<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return Student::query()->with('courses')->find(Auth::id());
        return view('questionnaire.student.index');
    }
}

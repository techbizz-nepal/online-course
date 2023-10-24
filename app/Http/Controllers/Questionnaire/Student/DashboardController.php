<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        return view('student.index');
    }
}

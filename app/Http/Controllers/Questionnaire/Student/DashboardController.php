<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\StudentData;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'student' => Student::query()
                ->where('id', Auth::id())
                ->with('courses')
                ->first(),
        ];

        return view('questionnaire.student.index', $data);
    }

    public function updateProfile(Request $request)
    {
        if ($request->method() === 'POST') {
            try {
                $studentData = StudentData::from($request->all());
                Student::query()
                    ->where('id', Auth::guard('student')->id())
                    ->update($studentData->toArray());
                return redirect()->back()->with('success', 'Profile Updated.');
            } catch (\Exception $exception) {
                return back()->withErrors(['msg' => $exception->getMessage()])->withInput();
            }
        }
        $data = [
            'student' => Auth::user(),
            'titleOptions' => [
                ['value' => 'mr', 'label' => 'Mr'],
                ['value' => 'mrs', 'label' => 'Mrs'],
                ['value' => 'dr', 'label' => 'Dr'],
            ],
            'genderOptions' => [
                ['value' => 'male', 'label' => 'Male'],
                ['value' => 'female', 'label' => 'Female'],
            ]
        ];
        return view('student.update-profile', $data);
    }
}

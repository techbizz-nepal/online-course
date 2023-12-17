<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\StudentData;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'courses' => StudentData::authenticatedGuard()->user()->courses()->get(),
        ];

        return view('questionnaire.student.index', $data);
    }

    public function updateProfile(Request $request): Application|View|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->method() === 'POST') {
            try {
                $studentData = StudentData::from($request->all());
                Student::query()
                    ->where('id', StudentData::authenticatedGuard()->id())
                    ->update($studentData->toArray());

                return redirect()->back()->with('success', 'Profile Updated.');
            } catch (\Exception $exception) {
                return back()->withErrors(['msg' => $exception->getMessage()])->withInput();
            }
        }
        $data = [
            'student' => StudentData::authenticatedGuard()->user(),
            'titleOptions' => [
                ['value' => 'mr', 'label' => 'Mr'],
                ['value' => 'mrs', 'label' => 'Mrs'],
                ['value' => 'dr', 'label' => 'Dr'],
            ],
            'genderOptions' => [
                ['value' => 'male', 'label' => 'Male'],
                ['value' => 'female', 'label' => 'Female'],
                ['value' => 'other', 'label' => 'Other'],
            ],
        ];

        return view('student.update-profile', $data);
    }
}

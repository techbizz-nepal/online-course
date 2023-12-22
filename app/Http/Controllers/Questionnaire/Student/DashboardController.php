<?php

namespace App\Http\Controllers\Questionnaire\Student;

use App\DTO\StudentData;
use App\Http\Controllers\Controller;
use App\Questionnaire\StudentFacade;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected StudentFacade $studentFacade)
    {

    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            'courses' => StudentData::authenticatedGuard()->user()->courses()->get(),
        ];

        return view('questionnaire.student.index', $data);
    }

    public function updateProfile(Request $request): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $student = StudentData::authenticatedGuard()->user();
        if ($request->method() === 'POST') {
            $studentData = StudentData::from($request->all());

            return $this->studentFacade->postUpdateProfile($studentData, $student);
        }
        $data = $this->studentFacade->getStudentWithFormInputs($student);
        $fetchSurveyData = $student->getAttribute('survey');

        $data['survey'] = $this->studentFacade->getEnquiryData($fetchSurveyData);

        return view('student.update-profile', $data);
    }
}

<?php

namespace App\Http\Controllers\Admin\Questionnaire;

use App\DTO\Questionnaire\AssessmentData;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    public function index()
    {
        return [];
    }

    public function create(Course $course)
    {
        return view('questionnaire.admin.assessments.create', ['course' => $course]);
    }

    public function store(Course $course, AssessmentData $assessmentData, Request $request)
    {
        DB::beginTransaction();
        try {
            $assessmentData->slug = Assessment::query()->where('slug', $assessmentData->slug)->exists()
                ? sprintf('%s-%s', $assessmentData->slug, Str::random(10))
                : $assessmentData->slug;
            QuestionnaireAdmin::createCourseAssessment($assessmentData, $course);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('on assessment insert', [$exception->getMessage()]);
            return back()
                ->withErrors(['errors' => __(key: 'assessment.errors.create')])
                ->withInput($assessmentData->toArray());
        }
        return redirect()
            ->route('admin.courses.show', ['course' => $course->getAttribute('slug')])
            ->with('success', __(key: 'assessment.success.create'));
    }

    public function show(Course $course, Assessment $assessment)
    {
        return [$course, $assessment];
    }

    public function edit(Course $course, Assessment $assessment)
    {
        return view('questionnaire.admin.assessments.edit', ['course' => $course, 'assessment' => $assessment]);
    }

    public function update(Course $course, Assessment $assessment, AssessmentData $assessmentData)
    {
        $assessment->update($assessmentData->toArray());
        return redirect()
            ->route('admin.courses.show', ['course' => $course->getAttribute('slug')])
            ->with('success', __(key: 'assessment.success.update'));
    }

    public function destroy(Course $course, Assessment $assessment): RedirectResponse
    {
        QuestionnaireAdmin::deleteCourseAssessmentMaterial($assessment);
        $assessment->delete();
        return back()->with('success', __('assessment.success.delete'));
    }

    public function uploadMaterial(Request $request, Course $course, Assessment $assessment): JsonResponse
    {
        try {
            if ($assessment->exists) {
                QuestionnaireAdmin::deleteCourseAssessmentMaterial($assessment);
            }
            $array = QuestionnaireAdmin::uploadCourseAssessmentMaterial($request, $course);
            return response()->json($array);
        } catch (\Exception $exception) {
            Log::error('while uploading assessment material', [$exception->getMessage()]);
            return response()->json(['error' => 'Can\'t upload file']);
        }
    }
}

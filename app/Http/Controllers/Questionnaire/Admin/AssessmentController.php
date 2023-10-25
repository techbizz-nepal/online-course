<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\AssessmentData;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Traits\HasRedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    use HasRedirectResponse;

    public function index(): array
    {
        return [];
    }

    public function create(Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.assessments.create', ['course' => $course]);
    }

    public function store(Course $course, AssessmentData $assessmentData): RedirectResponse
    {
        $newAssessment = null;
        DB::beginTransaction();
        try {
            $assessmentData->slug = Assessment::query()->where('slug', $assessmentData->slug)->exists()
                ? sprintf('%s-%s', $assessmentData->slug, Str::random(10))
                : $assessmentData->slug;
            $newAssessment = QuestionnaireAdmin::createCourseAssessment($assessmentData, $course);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->failureRedirectWithInputResponse(
                translationKey: 'assessment.errors.create',
                inputArray: $assessmentData->toArray()
            );
        }
        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.assessments.modules.create',
                routeParams: [
                    'course' => $course->getAttribute('slug'),
                    'assessment' => $newAssessment->getAttribute('slug')
                ],
                translationKey: 'assessment.success.create',
            );
    }

    public function show(Course $course, Assessment $assessment)
    {
        $data = [
            'course' => $course,
            'assessment' => $assessment->load(['modules'])
        ];
        return view('questionnaire.admin.assessments.show', $data);
    }

    public function edit(Course $course, Assessment $assessment)
    {
        return view('questionnaire.admin.assessments.edit', ['course' => $course, 'assessment' => $assessment]);
    }

    public function update(Course $course, Assessment $assessment, AssessmentData $assessmentData): RedirectResponse
    {
        $assessment->update($assessmentData->toArray());
        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.show',
                routeParams: ['course' => $course->getAttribute('slug')],
                translationKey: 'assessment.success.update'
            );
    }

    public function destroy(Course $course, Assessment $assessment): RedirectResponse
    {
        QuestionnaireAdmin::deleteCourseAssessmentMaterial($assessment);
        $assessment->delete();
        return $this->successRedirectResponse(translationKey: 'assessment.success.delete');
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

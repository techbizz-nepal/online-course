<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\AssessmentData;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Traits\HasAttributeRepository;
use App\Traits\HasRedirectResponse;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    use HasAttributeRepository, HasRedirectResponse;

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
            $assessmentData->slug = QuestionnaireAdmin::getNewIfAssessmentSlugExists($assessmentData, new Assessment());
            $newAssessment = QuestionnaireAdmin::createCourseAssessment($assessmentData, $course);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->failureRedirectWithInputResponse(
                translationKey: 'assessment.error.create',
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.assessments.modules.create',
                routeParams: [
                    'course' => $course->getAttribute('slug'),
                    'assessment' => $newAssessment->getAttribute('slug'),
                ],
                translationKey: 'assessment.success.create',
            );
    }

    public function show(Course $course, Assessment $assessment): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->getAssessmentShowAttributes($course, $assessment);

        return view('questionnaire.admin.assessments.show', $data);
    }

    public function edit(Course $course, Assessment $assessment): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.assessments.edit', ['course' => $course, 'assessment' => $assessment]);
    }

    public function update(Course $course, Assessment $assessment, AssessmentData $assessmentData): RedirectResponse
    {
        DB::beginTransaction();
        try {
            QuestionnaireAdmin::updateCourseAssessment($course, $assessmentData);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureRedirectWithInputResponse(
                translationKey: 'assessment.error.update',
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.show',
                routeParams: ['course' => $course->getAttribute('slug')],
                translationKey: 'assessment.success.update'
            );
    }

    public function destroy(Course $course, Assessment $assessment): RedirectResponse
    {
        QuestionnaireAdmin::deleteAssessmentMaterial($assessment);
        $assessment->delete();

        return $this->successRedirectResponse(translationKey: 'assessment.success.delete');
    }

    public function uploadMaterial(Request $request, Course $course, Assessment $assessment): JsonResponse
    {
        try {
            if ($assessment->exists) {
                QuestionnaireAdmin::deleteAssessmentMaterial($assessment);
            }

            return response()
                ->json(QuestionnaireAdmin::uploadAssessmentMaterial($request, $course));
        } catch (\Exception $exception) {
            Log::error('while uploading assessment material', [$exception->getMessage()]);

            return response()->json(['error' => 'Can\'t upload file']);
        }
    }
}

<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\ModuleData;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Traits\HasAttributeRepository;
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

class ModuleController extends Controller
{
    use HasAttributeRepository;
    use HasRedirectResponse;

    public function create(Course $course, Assessment $assessment): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.modules.create', ['course' => $course, 'assessment' => $assessment]);
    }

    public function store(Course $course, Assessment $assessment, ModuleData $moduleData): RedirectResponse
    {
        $newModule = null;
        DB::beginTransaction();
        try {
            $moduleData->slug = QuestionnaireAdmin::getNewIfModuleSlugExists($moduleData, new Module());
            $newModule = QuestionnaireAdmin::createCourseAssessmentModule($moduleData, $course, $assessment);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->failureRedirectWithInputResponse(
                translationKey: 'module.error.create'
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.assessments.modules.assessments.show',
                routeParams: [
                    'course' => $course->getAttribute('slug'),
                    'assessment' => $assessment->getAttribute('slug'),
                ],
                translationKey: 'module.success.create',
            );
    }

    public function show(Course $course, Assessment $assessment, Module $module)
    {
        $module->setAttribute('description', Str::words($module->getAttribute('description'), 50));
        $data = $this->getModuleShowAttributes($course, $assessment, $module);

        return view('questionnaire.admin.modules.show', $data);
    }

    public function edit(Course $course, Assessment $assessment, Module $module): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.modules.edit', ['course' => $course, 'assessment' => $assessment, 'module' => $module]);
    }

    public function update(Course $course, Assessment $assessment, Module $module, ModuleData $moduleData)
    {
        DB::beginTransaction();
        try {
            QuestionnaireAdmin::updateCourseAssessmentModule($assessment, $moduleData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->failureRedirectWithInputResponse(
                translationKey: 'module.error.update'
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.assessments.show',
                routeParams: ['course' => $course->getAttribute('slug'), 'assessment' => $assessment->getAttribute('slug')],
                translationKey: 'module.success.update'
            );
    }

    public function destroy(Course $course, Assessment $assessment, Module $module): RedirectResponse
    {
        QuestionnaireAdmin::deleteModuleMaterial($module);
        $module->delete();

        return $this->successRedirectResponse(translationKey: 'module.success.delete');
    }

    public function uploadMaterial(Request $request, Course $course, Assessment $assessment, Module $module): JsonResponse
    {
        try {
            if ($module->exists) {
                QuestionnaireAdmin::deleteModuleMaterial($module);
            }
            $array = QuestionnaireAdmin::uploadModuleMaterial($request, $assessment);

            return response()->json($array);
        } catch (\Exception $exception) {
            Log::error('while uploading module material', [$exception->getMessage()]);

            return response()->json(['error' => __('module.errors.uploadMaterial')]);
        }
    }
}

<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\ModuleData;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
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

    public function create(Course $course): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.modules.create', ['course' => $course]);
    }

    public function store(Course $course, ModuleData $moduleData): RedirectResponse
    {
        $newModule = null;
        DB::beginTransaction();
        try {
            $moduleData->slug = QuestionnaireAdmin::getNewIfModuleSlugExists($moduleData, new Module());
            QuestionnaireAdmin::createCourseModule($moduleData, $course);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->failureRedirectWithInputResponse(
                translationKey: 'module.error.create'
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.show',
                routeParams: [
                    'course' => $course->getAttribute('slug'),
                ],
                translationKey: 'module.success.create',
            );
    }

    public function show(Course $course, Module $module)
    {
        $module->setAttribute('description', Str::words($module->getAttribute('description'), 50));
        $data = $this->getModuleShowAttributes($course, $module);

        return view('questionnaire.admin.modules.show', $data);
    }

    public function edit(Course $course, Module $module): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('questionnaire.admin.modules.edit', ['course' => $course, 'module' => $module]);
    }

    public function update(Course $course, Module $module, ModuleData $moduleData)
    {
        DB::beginTransaction();
        try {
            QuestionnaireAdmin::updateCourseModule($course, $moduleData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->failureRedirectWithInputResponse(
                translationKey: 'module.error.update'
            );
        }

        return $this
            ->successRedirectWithParamsResponse(
                routeName: 'admin.courses.show',
                routeParams: ['course' => $course->getAttribute('slug')],
                translationKey: 'module.success.update'
            );
    }

    public function destroy(Course $course, Module $module): RedirectResponse
    {
        QuestionnaireAdmin::deleteModuleMaterial($module);
        $module->delete();

        return $this->successRedirectResponse(translationKey: 'module.success.delete');
    }

    public function uploadMaterial(Request $request, Course $course, Module $module): JsonResponse
    {
        try {
            if ($module->exists) {
                QuestionnaireAdmin::deleteModuleMaterial($module);
            }
            $array = QuestionnaireAdmin::uploadModuleMaterial($request, $course);

            return response()->json($array);
        } catch (\Exception $exception) {
            Log::error('while uploading module material', [$exception->getMessage()]);

            return response()->json(['error' => __('module.errors.uploadMaterial')]);
        }
    }
}

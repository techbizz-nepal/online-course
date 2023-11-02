<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Services\Questionnaire\Types\InterfaceType;
use App\Traits\HasRedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use HasRedirectResponse;

    public function __construct(protected InterfaceType $type)
    {
    }

    public function create(
        Course $course,
        Assessment $assessment,
        Module $module,
        Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->type->getQuestionCreateAttributes($request, $course, $assessment, $module);

        return view('questionnaire.admin.questions.create', $data);
    }

    public function show(Course $course, Assessment $assessment, Module $module, Question $question): Collection
    {
        return $question->option()->get();
    }

    public function store(
        Course $course,
        Assessment $assessment,
        Module $module,
        QuestionData $questionData,
        Request $request)
    {
        $validated = $this->type->validated($request);
        DB::beginTransaction();
        try {
            $this->type->storeProcess($validated, $module, $questionData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('while creating question: ', [$exception->getMessage()]);

            return $this->failureRedirectWithInputResponse(translationKey: '');
        }

        return $this->successRedirectWithParamsResponse(
            routeName: 'admin.courses.assessments.modules.show',
            routeParams: ['course' => $course, 'assessment' => $assessment, 'module' => $module],
            translationKey: 'question.success.create'
        );
    }

    public function edit(
        Course $course,
        Assessment $assessment,
        Module $module,
        Question $question)
    {
        $type = QuestionType::from($question->type);
        $data = $this->type
            ->getQuestionEditAttributes($course, $assessment, $module, $question, $type);

        return view('questionnaire.admin.questions.edit', $data);
    }

    public function update(
        Course $course,
        Assessment $assessment,
        Module $module,
        Question $question,
        QuestionData $questionData,
        Request $request
    ): RedirectResponse {
        $validated = $this->type->validated($request);
        try {
            $this->type->updateProcess($validated, $question, $questionData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());

            return $this->failureRedirectResponse(translationKey: 'question.error.update');
        }

        return $this->successRedirectWithParamsResponse(
            routeName: 'admin.courses.assessments.modules.show',
            routeParams: ['course' => $course, 'assessment' => $assessment, 'module' => $module],
            translationKey: 'question.success.edit'
        );
    }

    public function destroy(Course $course, Assessment $assessment, Module $module, Question $question): RedirectResponse
    {
        $this->type->deleteProcess($question);

        return $this->successRedirectResponse(translationKey: 'question.success.delete');
    }

    public function uploadMaterial(Request $request, Course $course, Assessment $assessment, Module $module, Question $question): JsonResponse
    {
        try {
            if ($question->exists) {
                QuestionnaireAdmin::deleteQuestionMaterial($question);
            }
            $array = QuestionnaireAdmin::uploadQuestionMaterial($request, $module);

            return response()->json($array);
        } catch (\Exception $exception) {
            Log::error('while uploading question material', [$exception->getMessage()]);

            return response()->json(['error' => __('question.errors.uploadMaterial')]);
        }
    }
}

<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\QuestionImageableRequest;
use App\Models\Course;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Questionnaire\Services\Admin\InterfaceAdmin;
use App\Traits\HasRedirectResponse;
use Exception;
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

    /**
     * @throws Exception
     */
    public function __construct(protected InterfaceAdmin $type)
    {
    }

    public function create(
        Course $course,
        Module $module,
        Request $request
    ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $data = [
            'params' => [
                'course' => $course->getAttribute('slug'),
                'module' => $module->getAttribute('slug'),
                'type' => $request->get('type'),
            ],
        ];

        return view('questionnaire.admin.questions.create', $data);
    }

    public function show(Course $course, Module $module, Question $question): Collection
    {
        return $question->option()->get();
    }

    public function store(
        Course $course,
        Module $module,
        QuestionData $questionData,
        Request $request
    ) {
        $validated = $this->type->validated($request);

        DB::beginTransaction();
        try {
            $this->type->storeProcess($validated, $module, $questionData);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('while creating question: ', [$exception->getMessage()]);

            return $this->failureRedirectWithInputResponse(translationKey: '');
        }

        return $this->successRedirectWithParamsResponse(
            routeName: 'admin.courses.modules.show',
            routeParams: ['course' => $course, 'module' => $module],
            translationKey: 'question.success.create'
        );
    }

    public function edit(
        Course $course,
        Module $module,
        Question $question
    ) {
        $data = [
            'question' => $question->load(QuestionType::from($question->type->value)->relation()),
            'params' => [
                'course' => $course->getAttribute('slug'),
                'module' => $module->getAttribute('slug'),
                'question' => $question->getAttribute('id'),
                'type' => $question->type,
            ],
        ];

        return view('questionnaire.admin.questions.edit', $data);
    }

    public function update(
        Course $course,
        Module $module,
        Question $question,
        QuestionData $questionData,
        Request $request
    ) {
        $validated = $this->type->validated($request);
        try {
            if ($this->type->updateProcess($validated, $question, $questionData)) {
                DB::commit();
            } else {
                DB::rollBack();

                return $this->failureRedirectResponse(translationKey: 'question.error.update');
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());

            return $this->failureRedirectResponse(translationKey: 'question.error.update');
        }

        return $this->successRedirectWithParamsResponse(
            routeName: 'admin.courses.modules.show',
            routeParams: ['course' => $course, 'module' => $module],
            translationKey: 'question.success.edit'
        );
    }

    public function destroy(Course $course, Module $module, Question $question): RedirectResponse
    {
        $this->type->deleteProcess($question);

        return $this->successRedirectResponse(translationKey: 'question.success.delete');
    }

    public function uploadOrUpdateImage(QuestionImageableRequest $request, Module $module, Question $question): JsonResponse
    {
        try {
            $type = QuestionType::from($request->get('type'));
            $typeImageSystemPath = $type->getTypeSystemPath();
            $typeActionableObject = $type->getActionableQuestionObject();

            $response = $typeActionableObject->uploadSingleImage($request->validated(), $module, $typeImageSystemPath);

            return response()->json($response);
        } catch (Exception $exception) {
            Log::error("while uploading image -> question type {$this->type->getTypeValue()}", [$exception->getMessage()]);

            return response()->json(['error' => __('question.errors.uploadMaterial')]);
        }
    }
}

<?php

namespace App\Http\Controllers\Questionnaire\Admin;

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use App\Traits\HasRedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use HasRedirectResponse;

    public function create(Course $course, Assessment $assessment, Module $module, Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [
            "question" =>
                [
                    "requestType" => in_array($request->get('questionType'), QuestionType::toArray())
                        ? $request->get('questionType')
                        : QuestionType::CLOSE_ENDED_OPTIONS->value,
                    "types" =>
                        [
                            "closeOption" => QuestionType::CLOSE_ENDED_OPTIONS->value,
                            "readAndAnswer" => QuestionType::READ_AND_ANSWER->value,
                            "describeImage" => QuestionType::DESCRIBE_IMAGE->value
                        ]
                ],
            "course" => $course,
            "assessment" => $assessment,
            "module" => $module
        ];
        return view('questionnaire.admin.questions.create', $data);
    }

    public function show()
    {
        return [];
    }

    public function store(
        Course             $course,
        Assessment         $assessment,
        Module             $module,
        QuestionData       $questionData,
        QuestionOptionData $questionOptionData)
    {
        DB::beginTransaction();
        try {
            $question = tap(QuestionnaireAdmin::createQuestion($module, $questionData))->target;
            QuestionnaireAdmin::createQuestionOptions($question, $questionOptionData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->failureRedirectResponse(translationKey: "");
        }
        return $this->successRedirectWithParamsResponse(
            routeName: 'admin.courses.assessments.modules.show',
            routeParams: ["course" => $course, "assessment" => $assessment, "module" => $module],
            translationKey: 'question.success.create'
        );
    }

    public function edit(Course $course, Assessment $assessment, Module $module, Question $question)
    {
        $data = [
            "course" => $course,
            "assessment" => $assessment,
            "module" => $module,
            "question" => $question->load('options'),
            "types" =>
                [
                    "closeOption" => QuestionType::CLOSE_ENDED_OPTIONS->value,
                    "readAndAnswer" => QuestionType::READ_AND_ANSWER->value,
                    "describeImage" => QuestionType::DESCRIBE_IMAGE->value
                ]
        ];
        $view = match ($question->getAttribute('type')) {
            QuestionType::CLOSE_ENDED_OPTIONS->value => 'questionnaire.admin.questions.edit'
        };
        return view($view, $data);
    }

    public function update()
    {
        return [];
    }

    public function destroy(Course $course, Assessment $assessment, Module $module, Question $question): RedirectResponse
    {
        $question->options()->delete();
        $question->delete();
        return $this->successRedirectResponse(translationKey: 'question.success.delete');
    }

}

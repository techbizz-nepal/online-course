<?php

namespace App\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

final readonly class StudentFacade
{
    public function __construct()
    {
    }

    public function startExam(Module $module): Model|Builder|null
    {
        try {
            return Exam::query()->firstOrCreate([
                'module_id' => $module->id,
                'student_id' => Auth::guard('student')->id(),
            ])->with(['answers'])->first();
        } catch (\Exception $exception) {
            Log::error('while fetch or create exam: ', [$exception->getMessage()]);
            throw new \Error('Contact Developer');
        }
    }

    public function populateQuestions(Module $module): \Illuminate\Database\Eloquent\Collection|array
    {
        $studentID = Auth::id();
        $moduleID = $module->getAttribute('id');

        return Question::query()->where('module_id', $moduleID)
            ->with(['answers' => function ($query) use ($studentID) {
                $query->whereHas('exam', function ($query) use ($studentID) {
                    $query->where('student_id', $studentID);
                })->select('id', 'question_id', 'answer', 'is_correct', 'exam_id');
            }])->orderBy('created_at', 'desc')
            ->get();
    }

    public function getNextQuestion(Module $module, Question $question)
    {
        self::pullQuestionFromSession($module, $question);
        return collect(Session::get($module->slug))->first() ?? null;
    }

    public function startSession(Module $module, Collection $questionsOfModule): void
    {
        try {
            $filtered = self::filterQuestionForSession($questionsOfModule);
            Session::put($module->slug, $filtered);
        } catch (\Exception $exception) {
            Log::error('while storing questions: ', [$exception->getMessage()]);
        }
    }

    public function pullQuestionFromSession(Module $module, Question $question): void
    {
        try {
            $questions = Session::get($module->slug);
            $filtered = Arr::where($questions, function ($row) use ($question) {
                return $row['id'] !== $question->id;
            });
            Session::put($module->slug, $filtered);
        } catch (\Exception $exception) {
            Log::error('while storing questions: ', [$exception->getMessage()]);
        }
    }

    private function filterQuestionForSession(Collection $questionOfModule): array
    {
        $conditions = [
            'empty_answers' => function ($item) {
                return empty($item['answers']);
            },
            'type_1_4_correct_0' => function ($item) {
                return in_array($item['type'], QuestionType::getCorrectTypes()) && $item['answers'][0]['is_correct'] === 0;
            }
        ];

        return Arr::where($questionOfModule->toArray(), function ($item, $key) use ($conditions) {
            foreach ($conditions as $conditionName => $conditionCallback) {
                if ($conditionCallback($item)) {
                    return true;
                }
            }

            return false;
        });
    }

    //    public function getAssessmentsByStudent(Course $course): \Illuminate\Database\Eloquent\Collection
    //    {
    //        return $this->assessmentRepo->getAssessmentsByStudent($course);
    //    }
}

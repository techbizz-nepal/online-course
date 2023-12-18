<?php

namespace App\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

final readonly class StudentFacade
{
    public function startExam(Module $module)
    {
        $createAttributes = [
            'module_id' => $module->id,
            'student_id' => Auth::guard('student')->id(),
        ];
        $queryAttributes = [
            ['module_id', '=', $module->id],
            ['student_id', '=', Auth::guard('student')->id()],
        ];

        $exam = Exam::query()->where($queryAttributes)->first();
        if ($exam === null) {
            $exam = Exam::query()->create($createAttributes);
        }

        return $exam;
    }

    public function populateAnsweredQuestions(Exam $exam): array
    {
        $list = [];
        Exam::query()
            ->with('examQuestion')
            ->where([
                ['student_id', '=', Auth::guard('student')->id()],
                ['id', '=', $exam->getAttribute('id')],
            ])
            ->get()
            ->each(function (Exam $exam) use (&$list) {
                foreach ($exam->examQuestion as $item) {
                    $row = [
                        'id' => $item->id,
                        'body' => $item->body,
                        'type' => $item->type->value(),
                    ];
                    if (in_array($item->type->value, QuestionType::getCorrectTypes()) && $item->pivot->is_correct) {
                        $row['status'] = 'correctly answered';
                        $row['action'] = null;
                    } else {
                        $row['status'] = 'incorrectly answered';
                        $row['action'] = 'retake';
                    }
                    if (in_array($item->type->value, QuestionType::getReviewTypes())) {
                        $row['status'] = 'answered';
                        $row['action'] = null;
                    }
                    $list[] = $row;
                }

                return $exam;
            });

        return $list;
    }

    //    public function populateQuestions(Module $module): \Illuminate\Database\Eloquent\Collection|array
    //    {
    //        $studentID = Auth::guard('student')->id();
    //        $moduleID = $module->getAttribute('id');
    //
    //        return Question::query()->where('module_id', $moduleID)
    //            ->with(['answers' => function ($query) use ($studentID) {
    //                $query->whereHas('exam', function ($query) use ($studentID) {
    //                    $query->where('student_id', $studentID);
    //                })->select('id', 'question_id', 'answer', 'is_correct', 'exam_id');
    //            }])->orderBy('created_at', 'desc')
    //            ->get();
    //    }

    public function populateQuestions(Module $module, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return Question::byModuleId($module->getAttribute('id'))
            ->select($columns)
            ->get();
    }

    public function getMappedQuestionsWithAnswers(Module $module, Exam $exam): Collection
    {
        $mapped = collect();
        $questions = $this->populateQuestions($module)->toArray();
        $answeredQuestions = collect($this->populateAnsweredQuestions($exam));

        array_walk($questions, function ($value, $key) use ($answeredQuestions, &$mapped) {
            if (in_array($value['id'], $answeredQuestions->pluck('id')->toArray())) {
                $answered = $answeredQuestions->firstWhere('id', $value['id']);
                $value['status'] = $answered['status'];
                $value['action'] = $answered['action'];
            } else {
                $value['status'] = 'new';
                $value['action'] = 'open';
            }
            $mapped[] = $value;
        });

        return $mapped;
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
            $questions = Session::get($module->slug) ?? [];
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
        $filtered = $questionOfModule->whereIn('status', ['incorrectly answered', 'new']);

        return $filtered->all();
    }
}

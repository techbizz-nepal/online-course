<?php

namespace App\Models\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'questionnaire_modules';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function questionReviewType(): HasMany
    {
        return $this->questions()->whereIn('type', QuestionType::getReviewTypes());
    }

    public function questionCorrectType(): HasMany
    {
        return $this->questions()->whereIn('type', QuestionType::getCorrectTypes());
    }

    public static function getWithMetaInfo(Assessment $assessment)
    {
        return self::query()
            ->whereHas('assessment', function ($query) use ($assessment) {
                $query->where('id', $assessment->getAttribute('id'));
            })
            ->with(['questions.answers.exam' => function ($query) {
                $query->where('student_id', Auth::guard('student')->id());
            }])
            ->get()
            ->map(function ($module) {
                $questionsCount = $module->questions->count();

                $answered = $module->questions->flatMap(function ($question) {
                    return $question->answers->where('exam.student_id', Auth::guard('student')->id());
                })->count();

                $incorrect = $module->questions->flatMap(function ($question) {
                    return $question->answers->where('exam.student_id', Auth::guard('student')->id())
                        ->whereIn('question.type', QuestionType::getCorrectTypes())
                        ->where('is_correct', 0);
                })->count();

                $toReview = $module->questions->flatMap(function ($question) {
                    return $question->answers
                        ->where('exam.student_id', Auth::guard('student')->id())
                        ->whereIn('question.type', QuestionType::getReviewTypes());
                })->count();

                return [
                    'slug' => $module->slug,
                    'name' => $module->name,
                    'questionCount' => $questionsCount,
                    'answered' => $answered,
                    'incorrect' => $incorrect,
                    'toReview' => $toReview,
                ];
            });
    }
}

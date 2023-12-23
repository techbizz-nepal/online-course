<?php

namespace App\Models\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Course;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $slug
 */
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function scopeQuestionsReviewType(): HasMany
    {
        return $this->questions()->whereIn('type', QuestionType::getReviewTypes());
    }

    public function scopeQuestionsCorrectType(): HasMany
    {
        return $this->questions()->whereIn('type', QuestionType::getCorrectTypes());
    }

    public function mutateWithScoreStatus(): void
    {
        foreach ($this->exams as $exam) {
            $pluckedScore = $exam->pluckScore();
            $this->score = $pluckedScore->sum();
            $this->pass = false;
            $this->answered = $pluckedScore->count();
            if ($this->score >= $this->passMark) {
                $this->pass = true;
            }
        }
    }
}

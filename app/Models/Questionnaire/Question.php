<?php

namespace App\Models\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property QuestionType $type
 * @property BelongsToMany $examQuestion
 *
 * @method static void byModuleId(string $module_id)
 */
class Question extends Model
{
    use HasFactory;
    use HasRelationships;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'questionnaire_questions';

    protected $attributes = [
        'type' => QuestionType::TRUE_FALSE,
    ];

    protected $casts = [
        'type' => QuestionType::class,
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function option(): HasOne
    {
        return $this->hasOne(QuestionOption::class);
    }

    public function readAndAnswer(): HasOne
    {
        return $this->hasOne(QuestionReadAndAnswer::class);
    }

    public function seeAndAnswer(): HasOne
    {
        return $this->hasOne(QuestionSeeAndAnswer::class);
    }

    public function trueFalse(): HasOne
    {
        return $this->hasOne(QuestionTrueFalse::class);
    }

    public function describeImage(): HasOne
    {
        return $this->hasOne(QuestionDescribeImage::class);
    }

    /**
     * This should be actually named exam_question table name, and method name should be examAnswer
     * after refactoring codes remove answers() method from this class
     */
    public function examQuestion(): BelongsToMany
    {
        return $this->belongsToMany(
            Exam::class,
            table: 'questionnaire_exam_question',
            foreignPivotKey: 'exam_id',
            relatedPivotKey: 'question_id');
    }

    public function scopeByModuleId(Builder $query, string $module_id): void
    {
        $query->where('module_id', $module_id);
    }
}

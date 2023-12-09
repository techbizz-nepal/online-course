<?php

namespace App\Models\Questionnaire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property BelongsToMany $examQuestion
 */
class Exam extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    protected $table = 'questionnaire_exams';

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * This should be actually named exam_question table name, and method name should be examAnswer
     * after refactoring codes remove answers() method from this class
     */
    public function examQuestion(): BelongsToMany
    {

        return $this
            ->belongsToMany(
                Question::class,
                table: 'questionnaire_exam_question',
                foreignPivotKey: 'exam_id',
                relatedPivotKey: 'question_id'
            )->withPivot(['answer']);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

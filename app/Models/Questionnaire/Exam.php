<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property BelongsToMany $questionAnswer
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
    public function questionAnswer(): BelongsToMany
    {
        return $this
            ->belongsToMany(Question::class, 'questionnaire_answers', 'exam_id', 'question_id')
            ->withPivot('answer', 'is_correct');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}

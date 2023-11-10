<?php

namespace App\Models\Questionnaire;

use App\Models\Course;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Assessment extends Model
{
    use HasFactory;
    use HasRelationships;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'questionnaire_assessments';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, Module::class);
    }

    public function getPercentageOfQuestionsAnswered(): float|int
    {
        $studentID = Auth::guard('student')->id();
        $answeredQuestionsCount = Answer::query()
            ->whereHas('exam', function ($query) use ($studentID) {
                $query->where('student_id', $studentID);
            })
            ->whereIn('question_id', function ($query) {
                $query->select('questionnaire_questions.id')->from('questionnaire_questions')
                    ->join('questionnaire_modules', 'questionnaire_questions.module_id', '=', 'questionnaire_modules.id')
                    ->where('questionnaire_modules.assessment_id', $this->id);
            })->count();

        $totalQuestionsCount = Question::query()
            ->whereIn('module_id', function ($query) {
                $query->select('id')->from('questionnaire_modules')
                    ->where('assessment_id', $this->id);
            })->count();

        return ($totalQuestionsCount > 0) ? (($answeredQuestionsCount / $totalQuestionsCount) * 100) : 0;
    }
}

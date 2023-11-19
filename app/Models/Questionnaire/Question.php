<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Question extends Model
{
    use HasFactory;
    use HasRelationships;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'questionnaire_questions';

    protected $with = ['option', 'trueFalse', 'readAndAnswer', 'describeImage'];

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

    public function trueFalse(): HasOne
    {
        return $this->hasOne(QuestionTrueFalse::class);
    }

    public function describeImage(): HasOne
    {
        return $this->hasOne(QuestionDescribeImage::class);
    }
}

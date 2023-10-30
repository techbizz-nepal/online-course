<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Question extends Model
{
    use HasFactory, HasRelationships, SoftDeletes, HasUuids;

    protected $guarded = [];

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
        return $this->hasOne(ReadAndAnswer::class);
    }
}

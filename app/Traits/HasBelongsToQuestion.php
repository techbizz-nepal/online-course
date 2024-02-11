<?php

namespace App\Traits;

use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasBelongsToQuestion
{
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}

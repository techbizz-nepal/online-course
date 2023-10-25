<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}

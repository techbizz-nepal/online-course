<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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
}
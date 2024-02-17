<?php

namespace App\Models;

use App\Models\Questionnaire\Exam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password'];

    protected $casts = [
        'survey' => 'array',
    ];

    protected $appends = ['fullName'];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withTimestamps()->as('purchased');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', $this->first_name, $this->surname);
    }

    public function scopeByID($query, $id)
    {
        return $query->where('id', $id);
    }
}

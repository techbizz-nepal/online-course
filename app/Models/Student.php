<?php

namespace App\Models;

use App\Models\Questionnaire\Exam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}

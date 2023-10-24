<?php

namespace App\Models;

use App\Models\Questionnaire\Assessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function bookingDates()
    {
        return $this->hasMany(BookingDate::class);
    }

    public function page()
    {
        return $this->hasOne(Page::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}

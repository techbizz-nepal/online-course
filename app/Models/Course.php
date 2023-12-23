<?php

namespace App\Models;

use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Course extends Model
{
    use HasFactory;
    use HasRelationships;
    use SoftDeletes;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function bookingDates(): HasMany
    {
        return $this->hasMany(BookingDate::class);
    }

    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, Module::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->as('purchased');
    }
}

<?php

namespace App\Models;

use App\Models\Questionnaire\Assessment;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
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

    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(Module::class, Assessment::class);
    }

    public function questions(): HasManyDeep
    {
        return $this->hasManyDeep(Question::class, [Assessment::class, Module::class]);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }
}

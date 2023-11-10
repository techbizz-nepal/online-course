<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    protected $table = 'questionnaire_exams';

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}

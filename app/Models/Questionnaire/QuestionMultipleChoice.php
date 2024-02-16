<?php

namespace App\Models\Questionnaire;

use App\Traits\HasBelongsToQuestion;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionMultipleChoice extends Model
{
    use HasBelongsToQuestion;
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'questionnaire_question_multiple_choices';

    protected $casts = [
        'body' => 'array',
    ];
}

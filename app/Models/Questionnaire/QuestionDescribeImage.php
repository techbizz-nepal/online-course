<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionDescribeImage extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'questionnaire_question_describe_images';

    protected $guarded = [];

    protected $casts = [
        'questions' => 'array',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}

<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QuestionOptionData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string       $id,
        public string                $option1,
        public string                $option2,
        public string                $option3,
        public string                $option4,
        #[MapInputName('is_correct')]
        public ?string                $isCorrect,
        public Optional|Carbon|null  $created_at,
        public Optional|Carbon|null  $updated_at,
        public Optional|Carbon|null  $deleted_at,
        public Optional|QuestionData $question
    )
    {
    }
}

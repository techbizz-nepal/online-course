<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QuestionMultipleChoiceData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public Optional|string $question_id,
        public array $body,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
    ) {
    }
}

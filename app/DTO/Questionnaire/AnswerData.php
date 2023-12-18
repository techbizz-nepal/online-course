<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AnswerData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public string $exam_id,
        public string $question_id,
        public array|string $answer,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
        public Optional|bool $is_correct = false,
        public Optional|int $score = 0
    ) {
    }
}

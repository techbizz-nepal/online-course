<?php

namespace App\DTO\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QuestionData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public string $body,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
        public Optional|string|null $module_id,
        public QuestionType $type,
        public int $weight = 0,
        public int $order = 0,
    ) {
    }
}

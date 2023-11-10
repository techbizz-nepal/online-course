<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ExamData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public string $student_id,
        public string $module_id,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
    ) {
    }
}

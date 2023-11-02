<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AssessmentData extends Data
{
    const SYSTEM_PATH = 'app/public/files/assessments';

    const PUBLIC_PATH = 'storage/files/assessments';

    public function __construct(
        #[Max(300)]
        public string $name,
        public Optional|string|null $id,
        #[Unique('assessments'), Max(500)]
        public ?string $slug,
        public ?string $description,
        public ?string $material,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
        public Optional|string|null $course_id
    ) {
        $this->slug ??= Str::slug($this->name);
    }
}

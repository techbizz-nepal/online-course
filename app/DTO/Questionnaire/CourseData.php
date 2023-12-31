<?php

namespace App\DTO\Questionnaire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CourseData extends Data
{
    public const SYSTEM_PATH = 'app/public/images/courses';

    public const PUBLIC_PATH = 'storage/images/courses';

    public function __construct(
        public Optional|string $id,
        public string $title,
        public ?string $slug,
        public string $price,
        public Optional|string $booking_dates,
        public Optional|Collection $assessments,
        public Optional|string $image,
        public ?string $department,
        public string $description,
        public string $course_code,
        public string $campus,
        public string $study_area,
        public string $course_length,
        public string $course_duration,
        public string $fee_details,
        public string $prerequisites,
        public ?string $additional_details,
        public Optional|string $detail_image,
        public ?string $display_order,
        public ?string $category_id,
        public ?string $created_at,
        public ?string $updated_at
    ) {
        $this->slug ??= Str::slug($this->title, '-');
    }
}

<?php

namespace App\DTO;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CourseData extends Data
{
    #[Computed]
    public string $slug;

    public function __construct(
        public string  $title,
        public string  $price,
        public string  $booking_dates,
        public Optional|string $image,
        public string  $description,
        public string  $course_code,
        public string  $campus,
        public string  $study_area,
        public string  $course_length,
        public string  $fee_details,
        public string  $prerequisites,
        public string  $additional_details,
        public Optional|string $detail_image,
        public string  $display_order,
        public string  $category_id

    )
    {
        $this->slug = Str::slug($this->title, '-');
    }
}

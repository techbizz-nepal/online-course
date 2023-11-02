<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QuestionDescribeImageData extends Data
{
    const SYSTEM_PATH = 'app/public/images/question_describe_images';

    const PUBLIC_PATH = 'storage/images/question_describe_images';

    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public string $image_path,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
        public Optional|string $question_id,
    ) {
    }
}

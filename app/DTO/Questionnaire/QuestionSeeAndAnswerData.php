<?php

namespace App\DTO\Questionnaire;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QuestionSeeAndAnswerData extends Data
{
    public const SYSTEM_PATH = 'app/public/images/question_see_and_answer_images';

    public const PUBLIC_PATH = 'storage/images/question_see_and_answer_images';

    public function __construct(
        #[Uuid]
        public Optional|string $id,
        public array $items,
        public Optional|string $question_id,
        public Optional|Carbon|null $created_at,
        public Optional|Carbon|null $updated_at,
        public Optional|Carbon|null $deleted_at,
    ) {
    }
}

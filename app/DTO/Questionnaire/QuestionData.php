<?php

namespace App\DTO\Questionnaire;

use App\Enums\Questionnaire\QuestionType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class QuestionData extends Data
{
    public function __construct(
        #[Uuid]
        public Optional|string         $id,
        public string                  $body,
        public Optional|Carbon|null    $created_at,
        public Optional|Carbon|null    $updated_at,
        public Optional|Carbon|null    $deleted_at,
        public Optional|string|null    $module_id,
        #[DataCollectionOf(QuestionOptionData::class)]
        public Optional|DataCollection $questionOptions,
        public int                     $order = 0,
        public QuestionType            $type = QuestionType::CLOSE_ENDED_OPTIONS,
    )
    {
    }
}

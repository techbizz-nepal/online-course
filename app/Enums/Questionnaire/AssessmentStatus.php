<?php

namespace App\Enums\Questionnaire;

enum AssessmentStatus: string
{
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';

    public function value(): string
    {
        return match ($this) {
            AssessmentStatus::IN_PROGRESS => 'In Progress',
            AssessmentStatus::COMPLETED => 'Completed'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}

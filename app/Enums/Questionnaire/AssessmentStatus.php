<?php

namespace App\Enums\Questionnaire;

enum AssessmentStatus: string
{
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';

    public function value(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed'
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}

<?php

namespace App\Enums\Questionnaire;

enum ColorType: string
{
    case RED = '1';
    case BRASS = '2';
    case BLUE = '3';
    case GREEN = '4';

    public function rgbCode(): string
    {
        return match ($this) {
            self::RED => 'rgb(255, 0, 0)',
            self::BRASS => 'rgb(225, 193, 110)',
            self::BLUE => 'rgb(0, 0, 255)',
            self::GREEN => 'rgb(34, 139, 34)',
        };
    }

    public function rgbaCode(): string
    {
        return match ($this) {
            self::RED => 'rgba(255, 0, 0, 0.2)',
            self::BRASS => 'rgba(225, 193, 110, 0.2)',
            self::BLUE => 'rgba(0, 0, 255, 0.2)',
            self::GREEN => 'rgba(34, 139, 34, 0.2)',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}

<?php

namespace App\Enums\Questionnaire;

enum QuestionType: string
{
    case CLOSE_ENDED_OPTIONS = '1';
    case READ_AND_ANSWER = '2';
    case DESCRIBE_IMAGE = '3';

    case TRUE_FALSE = '4';

    public function value(): string
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => 'Close Ended Options',
            self::READ_AND_ANSWER => 'Read and Answer',
            self::DESCRIBE_IMAGE => 'Describe Image',
            self::TRUE_FALSE => 'True False'
        };
    }

    public function relation(): string
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => 'option',
            self::READ_AND_ANSWER => 'readAndAnswer',
            self::DESCRIBE_IMAGE => 'describeImage',
            self::TRUE_FALSE => 'trueFalse'
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}

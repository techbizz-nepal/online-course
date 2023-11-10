<?php

namespace App\Enums\Questionnaire;

use App\Questionnaire\Services\Admin\ClosedOptionAdmin;
use App\Questionnaire\Services\Admin\DescribeImageAdmin;
use App\Questionnaire\Services\Admin\InterfaceAdmin;
use App\Questionnaire\Services\Admin\ReadAndAnswerAdmin;
use App\Questionnaire\Services\Admin\TrueFalseAdmin;
use App\Questionnaire\Services\Student\InterfaceStudent;

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

    public function getAdminServiceObject(): InterfaceAdmin
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => new ClosedOptionAdmin(),
            self::READ_AND_ANSWER => new ReadAndAnswerAdmin(),
            self::DESCRIBE_IMAGE => new DescribeImageAdmin(),
            self::TRUE_FALSE => new TrueFalseAdmin()
        };
    }

    public function getStudentServiceObject(): InterfaceStudent
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => new \App\Questionnaire\Services\Student\ClosedOptionService(),
            self::READ_AND_ANSWER => new \App\Questionnaire\Services\Student\ReadAndAnswerService(),
            self::DESCRIBE_IMAGE => new \App\Questionnaire\Services\Student\DescribeImageService(),
            default => new \App\Questionnaire\Services\Student\TrueFalseService(),
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getCorrectTypes(): array
    {
        return [self::CLOSE_ENDED_OPTIONS->value, self::TRUE_FALSE->value];
    }

    public static function getReviewTypes(): array
    {
        return [self::READ_AND_ANSWER->value, self::DESCRIBE_IMAGE->value];
    }
}

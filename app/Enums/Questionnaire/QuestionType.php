<?php

namespace App\Enums\Questionnaire;

use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionSeeAndAnswerData;
use App\Questionnaire\Services\Admin\ClosedOptionAdmin;
use App\Questionnaire\Services\Admin\DescribeImage;
use App\Questionnaire\Services\Admin\InterfaceAdmin;
use App\Questionnaire\Services\Admin\ReadAndAnswerAdmin;
use App\Questionnaire\Services\Admin\SeeAndAnswerAdmin;
use App\Questionnaire\Services\Admin\TrueFalseAdmin;
use App\Questionnaire\Services\Student\InterfaceStudent;
use Exception;

enum QuestionType: string
{
    case CLOSE_ENDED_OPTIONS = '1';
    case READ_AND_ANSWER = '2';
    case DESCRIBE_IMAGE = '3';
    case TRUE_FALSE = '4';
    case SEE_AND_ANSWER = '5';

    public function value(): string
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => 'Close Ended Options',
            self::READ_AND_ANSWER => 'Read and Answer',
            self::SEE_AND_ANSWER => 'See and Answer',
            self::DESCRIBE_IMAGE => 'Describe Image',
            self::TRUE_FALSE => 'True False',
        };
    }

    public function relation(): string
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => 'option',
            self::READ_AND_ANSWER => 'readAndAnswer',
            self::DESCRIBE_IMAGE => 'describeImage',
            self::TRUE_FALSE => 'trueFalse',
            self::SEE_AND_ANSWER => 'seeAndAnswer'
        };
    }

    public function getAdminServiceObject(): InterfaceAdmin
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => new ClosedOptionAdmin(),
            self::READ_AND_ANSWER => new ReadAndAnswerAdmin(),
            self::DESCRIBE_IMAGE => new DescribeImage(),
            self::TRUE_FALSE => new TrueFalseAdmin(),
            self::SEE_AND_ANSWER => new SeeAndAnswerAdmin()
        };
    }

    /**
     * @throws Exception
     */
    public function getActionableQuestionObject(): InterfaceAdmin
    {
        return match ($this) {
            self::DESCRIBE_IMAGE => new DescribeImage(),
            self::SEE_AND_ANSWER => new SeeAndAnswerAdmin(),
            self::TRUE_FALSE, self::CLOSE_ENDED_OPTIONS, self::READ_AND_ANSWER => throw new Exception('To be implemented'),
        };
    }

    public function getStudentServiceObject(): InterfaceStudent
    {
        return match ($this) {
            self::CLOSE_ENDED_OPTIONS => new \App\Questionnaire\Services\Student\ClosedOptionService(),
            self::READ_AND_ANSWER => new \App\Questionnaire\Services\Student\ReadAndAnswerService(),
            self::DESCRIBE_IMAGE => new \App\Questionnaire\Services\Student\DescribeImageService(),
            self::TRUE_FALSE => new \App\Questionnaire\Services\Student\TrueFalseService(),
            self::SEE_AND_ANSWER => new \App\Questionnaire\Services\Student\SeeAndAnswerService(),
        };
    }

    /**
     * @throws Exception
     */
    public function getTypeSystemPath(): string
    {
        return match ($this) {
            self::SEE_AND_ANSWER => QuestionSeeAndAnswerData::SYSTEM_PATH,
            self::DESCRIBE_IMAGE => QuestionDescribeImageData::SYSTEM_PATH,
            default => throw new Exception('To be implemented'),
        };
    }

    public function getTypePublicPath(): string
    {
        return match ($this) {
            self::SEE_AND_ANSWER => QuestionSeeAndAnswerData::PUBLIC_PATH,
            self::DESCRIBE_IMAGE => QuestionDescribeImageData::PUBLIC_PATH,
            default => throw new Exception('To be implemented'),
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
        return [self::READ_AND_ANSWER->value, self::DESCRIBE_IMAGE->value, self::SEE_AND_ANSWER->value];
    }

    public function getCreateViewName(): string
    {
        return match ($this) {
            self::READ_AND_ANSWER => 'questionnaire.admin.questions.types.read-and-answer.create',
            self::DESCRIBE_IMAGE => 'questionnaire.admin.questions.types.describe-image.create',
            self::TRUE_FALSE => 'questionnaire.admin.questions.types.true-false.create',
            self::CLOSE_ENDED_OPTIONS => 'questionnaire.admin.questions.types.closed-option.create',
            self::SEE_AND_ANSWER => 'questionnaire.admin.questions.types.see-and-answer.create',

        };
    }

    public function getEditViewName(): string
    {
        return match ($this) {
            self::READ_AND_ANSWER => 'questionnaire.admin.questions.types.read-and-answer.edit',
            self::DESCRIBE_IMAGE => 'questionnaire.admin.questions.types.describe-image.edit',
            self::TRUE_FALSE => 'questionnaire.admin.questions.types.true-false.edit',
            self::CLOSE_ENDED_OPTIONS => 'questionnaire.admin.questions.types.closed-option.edit',
            self::SEE_AND_ANSWER => 'questionnaire.admin.questions.types.see-and-answer.edit'
        };
    }

    public function getResultViewName(): string
    {
        return match ($this) {
            self::READ_AND_ANSWER => 'components.questionnaire.admin.types.read-and-answer',
            self::DESCRIBE_IMAGE => 'components.questionnaire.admin.types.describe-image',
            self::TRUE_FALSE => 'components.questionnaire.admin.types.true-false',
            self::CLOSE_ENDED_OPTIONS => 'components.questionnaire.admin.types.closed-options',
            self::SEE_AND_ANSWER => 'components.questionnaire.admin.types.see-and-answer'
        };
    }
}

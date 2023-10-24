<?php

namespace App\Facades\Questionnaire;

use Illuminate\Support\Facades\Facade;

class QuestionnaireStudent extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'student-service';
    }
}

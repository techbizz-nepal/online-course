<?php

use App\Http\Controllers\Questionnaire\Student\ExamController;
use Illuminate\Support\Facades\Route;

Route::controller(ExamController::class)
    ->middleware('auth:student')
    ->group(function () {
        Route::get('/course/{course}', 'listAssessments')
            ->name('courseCover');
        Route::get('/course/{course}/assessment/{assessment}', 'listModules')
            ->name('startExam');
        Route::get('/course/{course}/assessment/{assessment}/module/{module}', 'listQuestions')
            ->name('moduleStart');
        Route::get('/course/{course}/assessment/{assessment}/module/{module}/question/{question}/exam/{exam}', 'openQuestion')
            ->name('openQuestion');
        Route::post('/course/{course}/assessment/{assessment}/module/{module}/question/{question}/exam/{exam}', 'submitAnswer')
            ->name('submitAnswer');
    });

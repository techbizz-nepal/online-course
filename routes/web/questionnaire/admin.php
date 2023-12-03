<?php

use App\Http\Controllers\Questionnaire\Admin\AssessmentController;
use App\Http\Controllers\Questionnaire\Admin\CourseController;
use App\Http\Controllers\Questionnaire\Admin\ModuleController;
use App\Http\Controllers\Questionnaire\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::resource('courses', CourseController::class);
Route::resource('courses.assessments', AssessmentController::class);
Route::resource('courses.assessments.modules', ModuleController::class);
Route::resource('courses.assessments.modules.questions', QuestionController::class);

Route::controller(AssessmentController::class)
    ->name('courses.assessments.')
    ->group(function () {
        Route::post('courses/{course}/assessments/create-material', 'uploadMaterial')
            ->name('storeMaterial');
        Route::post('courses/{course}/assessments/{assessment}/update-material', 'uploadMaterial')
            ->name('updateMaterial');
    });

Route::controller(ModuleController::class)
    ->name('courses.assessments.modules.')
    ->group(function () {
        Route::post('courses/{course}/assessments/{assessment}/modules/create-material', 'uploadMaterial')
            ->name('storeMaterial');
        Route::post('courses/{course}/assessments/{assessment}/modules/{module}/update-material', 'uploadMaterial')
            ->name('updateMaterial');
    });

Route::controller(QuestionController::class)
    ->name('modules.questions.')
    ->group(function () {
        Route::post('modules/{module}/questions/image', 'uploadOrUpdateImage')
            ->name('uploadImage');
        Route::post('modules/{module}/questions/{question}/image', 'uploadOrUpdateImage')
            ->name('updateImage');
    });

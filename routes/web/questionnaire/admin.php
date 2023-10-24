<?php

use App\Http\Controllers\Admin\Questionnaire\AssessmentController;
use App\Http\Controllers\Admin\Questionnaire\CourseController;
use Illuminate\Support\Facades\Route;

Route::resources(
    [
        'courses' => CourseController::class,
        'courses.assessments' => AssessmentController::class
    ]
);
Route::post(
    'courses/{course}/assessments/{assessment}/update-material/', [AssessmentController::class, 'uploadMaterial']
)->name('courses.assessments.updateMaterial');
Route::post(
    'courses/{course}/assessments/create-material/', [AssessmentController::class, 'uploadMaterial']
)->name('courses.assessments.createMaterial');

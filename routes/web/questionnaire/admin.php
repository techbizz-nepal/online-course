<?php

use App\Http\Controllers\Questionnaire\Admin\{AssessmentController,
    CourseController,
    ModuleController,
    QuestionController
};
use Illuminate\Support\Facades\Route;

Route::resource('courses', CourseController::class);
Route::resource('courses.assessments', AssessmentController::class);
Route::resource('courses.assessments.modules', ModuleController::class);
Route::resource('courses.assessments.modules.questions', QuestionController::class);


Route::post(
    'courses/{course}/assessments/{assessment}/update-material/', [AssessmentController::class, 'uploadMaterial']
)->name('courses.assessments.updateMaterial');
Route::post(
    'courses/{course}/assessments/create-material/', [AssessmentController::class, 'uploadMaterial']
)->name('courses.assessments.storeMaterial');

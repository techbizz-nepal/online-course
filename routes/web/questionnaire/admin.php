<?php

use App\Http\Controllers\Admin\Questionnaire\CourseController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'course' => CourseController::class,
]);

<?php

use App\Http\Controllers\Auth\Student\LoginController;
use App\Http\Controllers\Questionnaire\Student\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)
    ->group(function () {
        Route::get('/login', 'showLoginForm')->name('getLogin');
        Route::post('/login', 'login')->name('postLogin');
        Route::post('logout', 'logout')->name('postLogout');
    });

Route::controller(DashboardController::class)
    ->middleware('auth:student')
    ->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::match(['get', 'post'], '/update-profile', 'updateProfile')->name('updateProfile');
    });

<?php

use App\Http\Controllers\Auth\Student\LoginController;
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)
    ->group(function () {
        Route::get('/login', 'showLoginForm')->name('getLogin')->middleware('guest:student');
        Route::post('/login', 'login')->name('postLogin')->middleware('guest:student');
        Route::post('logout', 'logout')->name('postLogout')->middleware('guest:student');
    });

Route::controller(DashboardController::class)
    ->middleware('auth:student')
    ->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

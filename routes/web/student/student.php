<?php

use App\Http\Controllers\Auth\Student\LoginController;
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('getLoginForm');
    Route::post('/login', 'login')->name('postLogin');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
});

<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MetaTagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [AdminController::class, 'dashboard'])->name('home');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::resources([
    'category' => CategoryController::class,
    'meta-tag' => MetaTagController::class,
    'page' => PageController::class,
    'banner' => BannerController::class,
]);
Route::resource('student', StudentController::class)->except(['index']);
Route::get('student/{query?}', [StudentController::class, 'index'])->name('student.index');
Route::get('student/{student}/qr/download', [StudentController::class, 'downloadQR'])->name('student.qr');
Route::get('student/{student}/exams', [StudentController::class, 'exams'])->name('student.exams');
Route::get('student/{student}/exams/{exam}/result', [StudentController::class, 'result'])->name('student.exams.result');

Route::get('/password/change', [PasswordController::class, 'showPasswordChangeForm'])->name('password.change');
Route::patch('/password/change', [PasswordController::class, 'change'])->name('password.change.post');

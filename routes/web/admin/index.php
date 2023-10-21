<?php

use App\Http\Controllers\Admin\{AdminController,
    BannerController,
    CategoryController,
    MetaTagController,
    PageController,
    PasswordController,
    StudentController};
use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::get('/', [AdminController::class, 'dashboard'])->name('home');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::resources([
    'category' => CategoryController::class,
    'meta-tag' => MetaTagController::class,
    'page' => PageController::class,
    'banner' => BannerController::class
]);
Route::resource('student', StudentController::class)->except(['index']);
Route::get('student/{query?}', [StudentController::class, 'index'])->name('student.index');
Route::get('student/{student}/qr/download', [StudentController::class, 'downloadQR'])->name('student.qr');

Route::get('/password/change', [PasswordController::class, 'showPasswordChangeForm'])->name('password.change');
Route::patch('/password/change', [PasswordController::class, 'change'])->name('password.change.post');

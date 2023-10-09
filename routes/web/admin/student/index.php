<?php

use Illuminate\Support\Facades\Route;

Route::name('student.')->prefix('student')->group(function () {
    Route::get("/optimized", function () {
        return "student route";
    })->name('optimized');
});

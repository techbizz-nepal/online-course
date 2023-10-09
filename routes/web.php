<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MetaTagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\Student\Auth\LoginController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'sendMessage'])->name('send.message')->middleware(ProtectAgainstSpam::class);
Route::get('/courses/{course}', [PagesController::class, 'course'])->name('course');
Route::get('/categories/{category}', [PagesController::class, 'category'])->name('category');

Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/{course}/add', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/cart/{course}/remove', [CartController::class, 'removeFromCart'])->name('removeFromCart');

Route::get('/checkout', [PurchaseController::class, 'checkout'])->name('checkout');

Route::post('/checkout', [PurchaseController::class, 'collectDetails'])->name('checkout-details');

Route::get('/payment', [PurchaseController::class, 'payment'])->name('payment');
Route::post('/payment', [PurchaseController::class, 'confirmPayment'])->name('confirmPayment');
Route::get('/payment/paypal', [PaymentController::class, 'paypal'])->name('paypal');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::get('/payment/zip', [PaymentController::class, 'zipPay'])->name('zip');
Route::get('/payment/zip/success', [PaymentController::class, 'zipSuccess'])->name('zip.success');
Route::get('/paymet/eway/success', [PaymentController::class, 'ewaySuccess'])->name('eway.success');
Route::get('/payment/eway', [PaymentController::class, 'eWay'])->name('eWay');

Route::get('/test', function () {
    dd(session()->get('user-checkout-details'));
    dd(session()->get('tacs'));
});

Route::prefix('admin')->group(function () {
    Auth::routes();
});

Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resources([
        'course' => CourseController::class,
        'category' => CategoryController::class,
        'meta-tag' => MetaTagController::class,
        'page' => PageController::class,
        'banner' => BannerController::class,
        'student' => StudentController::class,
    ]);

    Route::get('student/{student}/qr/download', [StudentController::class, 'downloadQR'])->name('student.qr');

    Route::get('/password/change', [PasswordController::class, 'showPasswordChangeForm'])->name('password.change');
    Route::patch('/password/change', [PasswordController::class, 'change'])->name('password.change.post');
});


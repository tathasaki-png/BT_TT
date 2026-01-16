<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order/place', [\App\Http\Controllers\OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/history', [\App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');
    Route::get('/order/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

    // Payment routes
    Route::post('/payment/create', [\App\Http\Controllers\PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment/return', [\App\Http\Controllers\PaymentController::class, 'handleReturn'])->name('payment.return');
    Route::get('/payment/success/{orderId}', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
    Route::post('/payment/check-status', [\App\Http\Controllers\PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::post('/payment/refund', [\App\Http\Controllers\PaymentController::class, 'requestRefund'])->name('payment.refund');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
});

require __DIR__.'/auth.php';

// VNPay Debug Routes (chỉ ở local environment)
if (app()->isLocal()) {
    Route::prefix('debug/vnpay')->group(function () {
        Route::get('/config', [\App\Http\Controllers\VNPayDebugController::class, 'config']);
        Route::get('/test-create-url', [\App\Http\Controllers\VNPayDebugController::class, 'testCreatePaymentUrl']);
        Route::get('/test-verify', [\App\Http\Controllers\VNPayDebugController::class, 'testVerifyResponse']);
        Route::get('/test-txn-ref', [\App\Http\Controllers\VNPayDebugController::class, 'testGenerateTransactionRef']);
        Route::get('/test-connection', [\App\Http\Controllers\VNPayDebugController::class, 'testConnection']);
        // Debug return URL
        Route::get('/return-test', function () {
            return view('debug.vnpay-return');
        });
    });
}

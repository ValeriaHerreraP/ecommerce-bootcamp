<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('welcome'); });

Route::middleware('auth', 'verified', 'user.enabled')->group(function () {
Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
Route::get('/enabled', function () { return view('enabled'); })->name('enabled');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/available_products', [CartController::class, 'shop'])->name('cart.shop');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.store');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/pay', [PaymentController::class, 'pay'])->name('cart.payments');
    Route::get('/result_payments', [PaymentController::class, 'processResponse'])->name('cart.resultPayments');
    Route::get('/payment_user', [PaymentController::class, 'userPaymentHistory'])->name('payments.index');
    Route::get('/order_details', [PaymentController::class, 'userOrderDetails'])->name('payments.detailsOrder');

});

Route::middleware('auth', 'admin')->group(function () {

    Route::resource('users', UserController::class);
    Route::put('users/{user}/update-state', [UserController::class, 'updateState'])->name('users.updateState');
   
    Route::resource('/products', ProductsController::class);
    Route::put('products/{product}/update-state', [ProductsController::class, 'updateState'])->name('products.updateState');
});









require __DIR__.'/auth.php';

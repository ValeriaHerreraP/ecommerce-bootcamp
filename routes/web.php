<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth', 'verified', 'user.enabled')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/enabled', function () {
        return view('enabled');
    })->name('enabled');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/available_products', [CartController::class, 'shop'])->name('cart.shop');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add_products_cart'])->name('cart.store');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove_item_cart'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

    Route::get('/pay', [PaymentController::class, 'pay'])->name('payments.detailsPayments');
    Route::get('/result_payments', [PaymentController::class, 'processResponse'])->name('cart.resultPayments');
    Route::get('/payment_user', [PaymentController::class, 'userPaymentHistory'])->name('payments.index');
    Route::get('/order_details', [PaymentController::class, 'userOrderDetails'])->name('payments.detailsOrder');
    Route::get('/order_retry', [PaymentController::class, 'retryPay'])->name('payments.retryOrder');
});

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::put('users/{user}/update-state', [UserController::class, 'update_state_enable'])->middleware(('can:users.updateStateEnable'))->name('users.updateStateEnable');
    Route::put('users/{user}/update-state0', [UserController::class, 'update_state_disable'])->middleware(('can:users.updateStateDisable'))->name('users.updateStateDisable');

    Route::resource('/products', ProductsController::class)->except(['show']);
    Route::put('products/{product}/show', [ProductsController::class, 'update_state_product_enable'])->middleware(('can:products.updateStateEnable'))->name('products.updateStateEnable');
    Route::put('products/{product}/disguise', [ProductsController::class, 'update_state_product_disable'])->middleware(('can:products.updateStateDisable'))->name('products.updateStateDisable');


    Route::get('/export_import', [ReportController::class, 'export_import'])->name('reports.ExportImport');
    Route::get('products/exportdw', [ReportController::class, 'export_download'])->middleware(('can:products.export'))->name('products.exportdw');
    Route::get('products/export', [ReportController::class, 'export_products_queue'])->middleware(('can:products.export'))->name('products.export');
    Route::post('products/import', [ReportController::class, 'import_products_queue'])->middleware(('can:products.import'))->name('products.import');
    Route::post('products/import_delete', [ReportController::class, 'import_products_queue_and_delete'])->middleware(('can:products.import'))->name('products.delete_import');
    Route::get('/report_general', [ReportController::class, 'index'])->middleware(('can:reports.general'))->name('reports.general');
    Route::get('/report_current_month', [ReportController::class, 'detailed_report_for_the_current_month'])->middleware(('can:reports.DetailMonth'))->name('reports.DetailMonth');

    
});

require __DIR__.'/auth.php';

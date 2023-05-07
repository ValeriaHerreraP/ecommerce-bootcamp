<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user.enabled'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/enabled', function () {
    return view('enabled');
})->name('enabled');

Route::resource('users', UserController::class);

Route::put('users/{user}/update-state', [UserController::class, 'updateState'])->name('users.updateState');

Route::get('productos', [PageController::class, 'productos'])->name('productos');

Route::resource('/products', ProductsController::class);

Route::put('products/{product}/update-state', [ProductsController::class, 'updateState'])->name('products.updateState');

require __DIR__.'/auth.php';

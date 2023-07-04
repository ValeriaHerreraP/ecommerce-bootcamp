<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
 //   return $request->user();
//});

Route::name('api.')->group(function () {
Route::apiResource('v1/products', App\Http\Controllers\Api\V1\ProductsController::class);
});

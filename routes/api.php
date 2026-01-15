<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Route::post('/cart/add', [CartController::class, 'add']);
    // Route::get('/cart', [CartController::class, 'view']);
    // Route::post('/checkout', [CheckoutController::class, 'checkout']);

});
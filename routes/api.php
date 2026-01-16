<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Route::post('/cart/add', [CartController::class, 'add']);
    // Route::get('/cart', [CartController::class, 'view']);
    // Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // Products & Vendors (browse)
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    Route::get('/vendors', [VendorController::class, 'index']);
    Route::get('/vendors/{id}', [VendorController::class, 'show']);

    // Cart (Customer)
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'view']);
    Route::put('/cart/item/{id}', [CartController::class, 'update']);
    Route::delete('/cart/item/{id}', [CartController::class, 'remove']);

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // Customer Orders (own orders)
    Route::get('/orders', [CheckoutController::class, 'myOrders']);

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'can:admin'])->prefix('admin')->group(function () {

    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);

});
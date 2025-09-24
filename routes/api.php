<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Dashboard\OrdersController;
use App\Http\Controllers\Api\Dashboard\ProductController;
use App\Http\Controllers\Api\HomeScreenController;
use App\Http\Controllers\Api\ProductsScreenController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');

// home and products
Route::get('/home', [HomeScreenController::class, 'index']);
Route::get('/products', [ProductsScreenController::class, 'index']);

Route::get('/products/{id}', [ProductsScreenController::class, 'show']);
Route::middleware(['auth:sanctum'])->as('api.')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // customer feature
    Route::middleware('role:customer')->group(function () {
        Route::apiResource('cart', CartController::class)->only(['index', 'store', 'destroy', 'update']);
        Route::post('cart/success', [CartController::class,  'payment']);
        Route::post('cart/sync', [CartController::class,  'sync']);
        Route::get('orders/items/{id}', [OrdersController::class,  'show']);
        Route::apiResource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy', 'update']);
    });

    // product manage and create
    Route::middleware('role:seller,admin')->group(function () {
        Route::apiResource('myproducts', ProductController::class)->parameters(['myproducts' => 'product'])->except('show');
        Route::patch('myproducts/{product}/restore', [ProductController::class, 'restore'])
            ->name('myproducts.restore');
    });
});

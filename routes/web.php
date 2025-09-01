<?php

use App\Http\Controllers\Dashboard\FeaturingController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ProductPageController;
use App\Http\Controllers\Website\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::resource('product', ProductPageController::class)->only(['index', 'show']);

Route::middleware([
    'auth:sanctum',
    // 'verified',
    config('jetstream.auth_session'),
])->group(function () {

    // Jetstream dashboard landing
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Products (Admin + Seller)
    Route::middleware('role:admin,seller')->group(function () {
        Route::resource('myproducts', ProductController::class)->parameters(['myproducts' => 'product'])->except('show');
        Route::patch('myproducts/{product}/restore', [ProductController::class, 'restore'])
            ->name('myproducts.restore');
    });

    // Orders (Admin + Customer)
    Route::middleware('role:admin,customer')->group(function () {
        Route::resource('orders', OrderController::class);
    });

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'show']);
        Route::resource('feature', FeaturingController::class)->parameters(['feature' => 'product'])->only('update');
    });


    // Cart and Wishlist
    Route::middleware('role:customer')->group(function () {
        Route::resource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy', 'update']);
        Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy', 'update']);
        Route::get('/payment', fn() => view('website.customer.payment'))->name('payment.page');
    });
});

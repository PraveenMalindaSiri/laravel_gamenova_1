<?php

use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ProductPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::resource('product', ProductPageController::class)->only(['index', 'show']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {

    // Jetstream dashboard landing
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Products (Admin + Seller)
    Route::middleware('role:admin,seller')->group(function () {
        Route::resource('myproducts', ProductController::class);
    });

    // Orders (Admin + Customer)
    Route::middleware('role:admin,customer')->group(function () {
        Route::resource('orders', OrderController::class);
    });

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

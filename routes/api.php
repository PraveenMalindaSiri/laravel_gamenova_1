<?php

use App\Http\Controllers\Api\HomeScreenController;
use App\Http\Controllers\Api\ProductsScreenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/home', [HomeScreenController::class, 'index']);
    Route::get('/products', [ProductsScreenController::class, 'index']);

    Route::middleware('role:customer')->group(function () {
        // cart/ wishlsit
    });

    Route::middleware('role:seller')->group(function () {
        // product crud
    });
});

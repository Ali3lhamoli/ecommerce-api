<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(ProductController::class)->group(function () {

        Route::get('/products', 'index');
        Route::get('/products/{product}', 'show');

        Route::middleware('admin')->group(function () {
            Route::post('/products', 'store');
            Route::put('/products/{product}', 'update');
            Route::delete('/products/{product}', 'destroy');
        });
    });

    Route::controller(OrderController::class)->group(function () {

        Route::get('/orders', 'index');
        Route::get('/orders/{order}', 'show');
        Route::post('/orders', 'store');

    });
});

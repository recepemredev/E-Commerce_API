<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

Route::prefix('auth')->group(function(){
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);
    Route::post('/logout',[AuthController::class, 'logout']);
});

Route::prefix('products')->group(function(){
    Route::get('',[ProductController::class, 'getProduct']);
    Route::get('/{id}',[ProductController::class, 'getProduct']);
    
    // Admin Only
    Route::middleware(['auth', 'AdminCheck'])->group(function () {
        Route::post('',[ProductController::class, 'createProduct']);
        Route::put('/{id}',[ProductController::class, 'updateProduct']);
        Route::delete('/{id}',[ProductController::class, 'deleteProduct']);
    });
});

Route::prefix('cart')->group(function(){
    // Registered User Only
    Route::middleware(['auth', 'AuthCheck'])->group(function () {
        Route::get('',[CartController::class, 'getCart']);
        Route::post('/items',[CartController::class, 'createCart']);
        Route::put('items/{id}',[CartController::class, 'updateCart']);
        Route::delete('items/{id}',[CartController::class, 'deleteCart']);
    });
});


Route::get('/check',[AuthController::class, 'authCheck']);


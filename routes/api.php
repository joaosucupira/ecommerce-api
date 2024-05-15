<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Http\Controllers\Api\ProductCategoryController;

/* Auth Routes */
Route::post('/login', LoginController::class);


// SECURED ROUTES
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/categories', CategoryController::class);

    Route::apiResource('products/{product}/categories', ProductCategoryController::class);
    Route::apiResource('/orders', OrderController::class);
    Route::apiResource('/orders/{order}/checkout', OrderController::class);
    
});

Route::apiResource('/products', ProductController::class);
Route::apiResource('/categories', CategoryController::class);

// PRODUCT
//Route::apiResource('/product', ProductController::class); // Descomentadada para teste de frontend

// CATEGORY
Route::apiResource('/category', CategoryController::class); // Descomentada para teste de frontend

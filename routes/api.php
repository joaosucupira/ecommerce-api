<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\OrderStatusesController;
use App\Http\Controllers\OrderItemController;

/* Auth Routes */
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

/* Secured Routes */
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::apiResource('/categories', CategoryController::class);
    // Route::apiResource('products/{product}/categories', ProductCategoryController::class);
    // Route::apiResource('/orders', OrderController::class);
    // Route::apiResource('/orders/{order}/checkout', OrderController::class);
    
});
// Products 
Route::apiResource('/products', ProductController::class);
Route::get('products/{product}/categories', [ProductController::class, 'categories']); // Categories of a Product
Route::get('/products/{id}/orders', [ProductController::class, 'orders']); // Orders that have that product

// Categories
Route::apiResource('/categories', CategoryController::class);
Route::get('categories/{category}/products', [CategoryController::class, 'products']); // Products from a Category

// Product Categories
Route::apiResource('/product-categories', ProductCategoryController::class); // Pivot table

// Orders
Route::apiResource('/orders', OrderController::class); 
Route::get('/orders/{id}/order-items', [OrderController::class, 'orderItems']); // Order items of an order
// Order Items
Route::apiResource('/order-items', OrderItemController::class); // 
Route::get('/order-items/{id}/order', [OrderItemController::class, 'order']); // Order of order item
Route::get('/order-items/{id}/product', [OrderItemController::class, 'product']); // Product of order item

// Order Statuses
Route::apiResource('/order-statuses', OrderStatusesController::class); 
Route::get('/orders/{id}/statuses', [OrderStatusesController::class, 'orderStatuses']); // Orders with that status




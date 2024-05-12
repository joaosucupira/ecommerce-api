<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;
// use App\Http\Controllers\ClienteController;
// use App\Http\Controllers\ItemController;
// use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

/* Auth Routes */
Route::post('/login', LoginController::class);

// Route::apiResource('/products', ProductController::class)->only(show, index);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::apiResource('/products', ProductController::class);
    // Route::apiResource('/orders', OrderController::class);
    // Route::apiResource('/orders/{order}/checkout', OrderController::class);
    
});


// PRODUCT
Route::apiResource('/product', ProductController::class);

// Route::post('/product', [ProductController::class, 'store']);
// CATEGORY
Route::apiResource('/category', CategoryController::class);


// DISCARDED ROUTES

// PEDIDO
// Route::get('/pedidos', [PedidoController::class, 'index']);
// Route::post('/pedidos', [PedidoController::class, 'store']);
// Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
// Route::put('/pedidos/{id}', [PedidoController::class, 'update']);
// Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy']);

// ITEM
// Route::get('/items', [ItemController::class, 'index']);
// Route::post('/items', [ItemController::class, 'store']);
// Route::get('/items/{id}', [ItemController::class, 'show']);
// Route::put('/items/{id}', [ItemController::class, 'update']);
// Route::delete('/items/{id}', [ItemController::class, 'destroy']);

// CLIENTE
// Route::get('/clientes', [ClienteController::class, 'index']);
// Route::post('/clientes', [ClienteController::class, 'store']);
// Route::get('/clientes/{id}', [ClienteController::class, 'show']);
// Route::put('/clientes/{id}', [ClienteController::class, 'update']);
// Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

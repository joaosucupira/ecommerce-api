<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Models\Product;

 

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('/products', ProductController::class);

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});



// token
// header -> Authorization -> Bearer

<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});



// token
// header -> Authorization -> Bearer

<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class,'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

//book
Route::get('/book', [BookController::class,'index']);
Route::post('/book', [BookController::class,'store']);
Route::get('/book/{id}', [BookController::class,'search']);
Route::put('/book/{id}', [BookController::class,'update']);
Route::delete('/book/{id}', [BookController::class,'destroy']);
<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('products', [ProductController::class, 'index']); 
Route::get('products/{id}', [ProductController::class, 'show']); 
Route::post('products', [ProductController::class, 'store']); 
Route::put('productsupdate/{id}', [ProductController::class, 'update']);
Route::delete('productdelete/{id}', [ProductController::class, 'destroy']);
Route::get('search/{key}',[ProductController::class,'search']);
Route::post('signup',[UserController::class,'signup']);
Route::post('login',[UserController::class,'login']);
// Route::delete('delete/{id}',[ProductController::class,'delete']);
// Route::get('product/{id}',[ProductController::class,'getProduct']);
// Route::put('updateproduct/{id}',[ProductController::class,'updateProduct']);




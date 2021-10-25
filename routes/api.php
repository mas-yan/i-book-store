<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/categoryHome', [CategoryController::class, 'category']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::get('/slider', SliderController::class);

Route::middleware('auth:api')->group(function () {
  Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:api');
  Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth:api');
  Route::post('/profile/password', [ProfileController::class, 'password'])->middleware('auth:api');
  Route::get('/cart', CartController::class)->middleware('auth:api');
});

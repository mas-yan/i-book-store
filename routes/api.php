<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\CheckOngkirController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::get('/categoryHome', [CategoryController::class, 'category']);
Route::get('/randCategory', [CategoryController::class, 'random']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::get('/slider', SliderController::class);

Route::middleware('auth:api')->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
  Route::get('/profile', [ProfileController::class, 'index']);
  Route::post('/profile', [ProfileController::class, 'update']);
  Route::post('/profile/password', [ProfileController::class, 'password']);
  Route::get('/store/{product}', [CartController::class, 'store']);
  Route::get('/destroyCart/{product}', [CartController::class, 'destroy']);
  Route::get('/qty/{product}', [CartController::class, 'addQty']);
  Route::get('/subtQty/{product}', [CartController::class, 'subtQty']);
  Route::get('/cart', [CartController::class, 'index']);
  Route::post('/cart/delete', [CartController::class, 'delete']);
  Route::get('/order', [OrderController::class, 'index']);
  Route::get('/order/{invoice}', [OrderController::class, 'show']);
  Route::post('/transaction', [OrderController::class, 'transaction']);
  // Route::post('/ongkir', [CheckOngkirController::class, 'check_ongkir']);
  // Route::get('/cities/{province_id}', [CheckOngkirController::class, 'getCities']);
  // Route::get('/provinces', [CheckOngkirController::class, 'index']);
  // tes
  Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
  Route::get('/cities/{province_id}', [RajaOngkirController::class, 'getCities']);
  Route::post('/ongkir', [RajaOngkirController::class, 'checkOngkir']);
});
Route::post('/transaction/notification', [OrderController::class, 'notificationHandler']);

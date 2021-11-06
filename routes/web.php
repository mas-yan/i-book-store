<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('categoriesTable', [CategoryController::class, 'categoriesTable'])->name('categoriesTable');
    Route::resource('/categories', CategoryController::class)->except('show');
    Route::get('/dataDiscount', [DiscountController::class, 'dataDiscount']);
    Route::resource('/discount', DiscountController::class)->except('show');
    Route::resource('/product', ProductController::class);
    Route::get('/dataProducts', [ProductController::class, 'dataProducts']);
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customerTable', [CustomerController::class, 'customerTable']);
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{invoice}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orderTable', [OrderController::class, 'orderTable']);
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::get('/profile', ProfileController::class)->name('profile.index');
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::put('/company/{id}', [CompanyController::class, 'update'])->name('company.update');
});

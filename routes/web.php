<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop-detail', [HomeController::class, 'shopDetail'])->name('shop.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/shopping-cart', [HomeController::class, 'shoppingCart'])->name('shopping.cart');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

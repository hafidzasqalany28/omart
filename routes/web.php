<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

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
Route::get('/shop-detail/{id}', [HomeController::class, 'shopDetail'])->name('shop.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/shop/filter', [HomeController::class, 'shop'])->name('shop.filter');


Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/shopping-cart', [HomeController::class, 'shoppingCart'])->name('shopping.cart');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('products', ProductController::class, ['as' => 'admin']); // masih belom kelar
        Route::resource('roles', RoleController::class, ['as' => 'admin'])->except(['show']);
        Route::resource('categories', CategoryController::class, ['as' => 'admin'])->except(['show']);
        Route::resource('promos', PromoController::class, ['as' => 'admin']);
        Route::resource('users', UserController::class, ['as' => 'admin']);
        Route::resource('reviews', ReviewController::class, ['as' => 'admin']);

        Route::resource('orders', OrderController::class, ['as' => 'admin']);
        Route::resource('payments', PaymentController::class, ['as' => 'admin']);
    });
});


Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

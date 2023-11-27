<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ReviewController;
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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');
Route::get('/order/history', [HomeController::class, 'orderHistory'])->name('order.history');
Route::post('/submit-review', [HomeController::class, 'submitReview'])->name('submit.review');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products');
    Route::get('/filter', [ProductController::class, 'index'])->name('products.filter');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.detail');
});

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');
// ->withoutMiddleware(['auth', 'customer'])
// ->middleware('auth.midtrans');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/profile', [HomeController::class, 'showProfile'])->name('profile');
    Route::patch('/profile/update', [HomeController::class, 'update'])->name('profile.update');
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'showCart'])->name('cart');
        Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    });
    Route::prefix('checkout')->group(function () {
        Route::get('/', [MidtransController::class, 'checkout'])->name('checkout');
        Route::get('/pay', [MidtransController::class, 'pay'])->name('checkout.pay');
    });
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

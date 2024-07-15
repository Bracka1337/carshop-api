<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\OrderController;

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

Route::get('/', MainController::class)->name('main');

//route to get csrf token
Route::get('/csrf-token', function () {
    return csrf_token();
});

Route::get('/products/{id}', [MainController::class, 'addProductsToCart'])->name('products.addToCart');
Route::post('/cart/update/{id}/{quantity}', [MainController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [MainController::class, 'removeFromCart'])->name('cart.remove');

// Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');



Route::post('/search', [SearchController::class, 'search'])->name('products.search');
Route::get('/search', [SearchController::class, 'search'])->name('products.search');

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class,'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('login.store');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('profile/orderdetails/{id}', [OrderController::class, 'show'])->name('orderdetails');

});

Route::group(['middleware' => ['can:access-admin']], function () {
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin');
});

//get session details
Route::get('/checkout', [MainController::class, 'getCart'])->name('checkout');
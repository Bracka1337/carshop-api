<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Admin\AdminController;

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
// Route::get('/csrf-token', function () {
//     return csrf_token();
// });

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'addProductsToCart'])->name('products.addToCart');

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
    Route::get('/profile/orderdetails', function () {
        return view('orderdetails');
    });
});

Route::group(['middleware' => ['can:access-admin']], function () {
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin');
});
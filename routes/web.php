<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

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


// Route::get('/', function () {
//     return view('main');
// });

Route::get('/', [ProductController::class, 'getSearchParameters'])->name('main');


//route to get csrf token
Route::get('/csrf-token', function () {
    return csrf_token();
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.store');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.store');

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/profile', [ProfileController::class,'show'])->name('profile.show');


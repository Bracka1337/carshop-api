<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

//route to get csrf token
Route::get('/csrf-token', function () {
    return csrf_token();
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.store');


Route::get('/aboutus', function () {
    return view('aboutus');
});
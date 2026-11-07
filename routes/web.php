<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CardPaymentController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CatalogueController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', CatalogueController::class)->name('main');
Route::get('/products/{id}', [CartController::class, 'addProductsToCart'])->name('products.addToCart');
Route::post('/cart/update/{id}/{quantity}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

Route::group(['middleware' => ['guest']], function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('profile/orderdetails/{order}', [OrderController::class, 'show'])->name('orderdetails');

    Route::get('/checkout', [CheckoutController::class, 'getCheckout'])->name('checkout');

    Route::post('/payment', [CheckoutController::class, 'proceedToPayment'])->name('proceedToPayment');

    Route::get('/payment-details', [CheckoutController::class, 'getPaymentDetails'])->name('payment-details');

    Route::post('/process-payment', [CardPaymentController::class, 'processPayment'])->name('processPayment');

    Route::get('/paymentSuccess', [CheckoutController::class, 'finalise'])->name('paymentSuccess');
});

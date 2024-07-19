<?php

use App\Http\Controllers\Api\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\FakePaymentController;
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
Route::get('/products/{id}', [MainController::class, 'addProductsToCart'])->name('products.addToCart');
Route::post('/cart/update/{id}/{quantity}', [MainController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [MainController::class, 'removeFromCart'])->name('cart.remove');






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

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('profile/orderdetails/{id}', [OrderController::class, 'show'])->name('orderdetails');

    Route::get('/checkout', [MainController::class, 'getCheckout'])->name('checkout');

    Route::get('/payment', [CheckoutController::class, 'proceedToPayment'])->name('proceedToPayment');

    Route::get('/payment-details', [MainController::class, 'getPaymentDetails'])->name('payment-details');

    Route::get('/process-payment', [FakePaymentController::class, 'processPayment'])->name('processPayment');

    Route::get('/paymentSuccess', [CheckoutController::class, 'finalise'])->name('paymentSuccess');
});

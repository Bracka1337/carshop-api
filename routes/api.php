<?php

use App\Http\Controllers\JsonApi\AuthTokenController;
use App\Http\Controllers\JsonApi\OrderController;
use App\Http\Controllers\JsonApi\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| JSON API (prefix /api, "api" middleware group)
|--------------------------------------------------------------------------
|
| Read-only API authenticated with Sanctum personal access tokens.
| The web shop itself keeps using session auth (routes/web.php).
|
*/

Route::post('/login', [AuthTokenController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('api.login');

Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('api.products.show');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthTokenController::class, 'destroy'])->name('api.logout');
    Route::get('/user', [AuthTokenController::class, 'show'])->name('api.user');

    Route::get('/orders', [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('api.orders.show');
});

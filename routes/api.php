<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/watches'], function () {
    Route::get('/', [WatchController::class, 'list'])->name('watches.list');
    Route::post('/', [WatchController::class, 'create'])->name('watches.create');
    Route::put('/reset', [WatchController::class, 'reset'])->name('watches.reset');
    Route::get('/{id}', [WatchController::class, 'show'])->name('watches.show');
});

Route::group(['prefix' => '/stock'], function () {
    Route::get('/{id?}',[StockController::class, 'getAmount']);
    Route::post('/{id?}',[StockController::class, 'setAmount']);
});

Route::group(['prefix' => '/cart'], function () {
    Route::get('/{user_id?}', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/', [CartController::class, 'clearCart'])->name('cart.clear');
});

Route::group(['prefix' => '/purchase'], function () {
    Route::post('/', [PurchaseController::class, 'proceed'])->name('purchase');
});


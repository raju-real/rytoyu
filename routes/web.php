<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(\App\Http\Controllers\HomePageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('single-product-info/{product_id}', 'singleProductInfo')->name('single-product-info');
    Route::get('product-details/{slug}', 'productDetails')->name('product-details');

    // Authentication Part
    Route::get('register','userRegisterPage')->name('register');
    Route::post('user-register','userRegistration')->name('user-register');
    Route::get('login','userLoginPage')->name('login');
    Route::post('user-login','userLogin')->name('user-login');
});

// Cart and Order
Route::controller(\App\Http\Controllers\CacheCartController::class)->group(function () {
    Route::get('cart-items', 'getCartItems')->name('cart-items');
    Route::get('load-cart-items', 'loadCartItems')->name('load-cart-items');
    Route::post('add-to-cart', 'addToCart')->name('add-to-cart');
    Route::delete('remove-item-from-cart', 'removeFromCart')->name('remove-item-from-cart');
    Route::post('update-cart-quantity', 'updateCartQuantity')->name('update-cart-quantity');
    Route::delete('clear-cart', 'clearCart')->name('clear-cart');
    Route::delete('flush-cache', 'flushCache')->name('clear-cart');
    // Checkout and Order
    Route::middleware('auth')->group(function () {
        Route::get('checkout','checkout')->name('checkout');
        Route::post('apply-coupon','applyCoupon')->name('apply-coupon');
        Route::get('price-summery','getPriceSummery')->name('price-summery');
        Route::get('load-price-summery','loadPriceSummery')->name('load-price-summery');
        Route::get('checkout-products','getCheckoutProducts')->name('checkout-products');
        Route::post('submit-order','submitOrder')->name('submit-order');
    });

});

// User Part
Route::controller(\App\Http\Controllers\User\ProfileController::class)->middleware('auth')->group(function () {
   Route::get('user-profile','profile')->name('user-profile');
   Route::get('user-logout','logout')->name('user-logout');
});



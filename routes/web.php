<?php

use App\Http\Controllers\User\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;
// Website Manage
Route::controller(\App\Http\Controllers\HomePageController::class)->group(function () {
    // Basic Activity
    Route::get('/', 'home')->name('home');
    Route::get('search-results', 'searchProduct')->name('search-products');
    Route::get('single-product-info/{product_id}', 'singleProductInfo')->name('single-product-info');
    Route::get('product-lists', 'products')->name('product-lists');
    Route::get('product-details/{slug}', 'productDetails')->name('product-details');

    Route::view('about','user.pages.about')->name('about');
    Route::view('contact','user.pages.contact')->name('contact');
    Route::post('send-contact-message','sendContactMessage')->name('send-contact-message');
    Route::view('faq','user.pages.faq')->name('faq');
    // Authentication Part
    Route::get('register', 'userRegisterPage')->name('register');
    Route::post('user-register', 'userRegistration')->name('user-register');
    Route::get('login', 'userLoginPage')->name('login');
    Route::post('user-login', 'userLogin')->name('user-login');
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
        Route::get('checkout', 'checkout')->name('checkout');
        Route::post('apply-coupon', 'applyCoupon')->name('apply-coupon');
        Route::get('price-summery', 'getPriceSummery')->name('price-summery');
        Route::get('set-shipping-fee', 'setShippingFee')->name('set-shipping-fee');
        Route::get('set-payment-method', 'setPaymentMethod')->name('set-payment-method');
        Route::get('load-price-summery', 'loadPriceSummery')->name('load-price-summery');
        Route::get('checkout-products', 'getCheckoutProducts')->name('checkout-products');
        Route::post('submit-order', 'submitOrder')->name('submit-order');
    });
});
// User Part
Route::middleware('auth')->group(function () {
    // Manage Profile
    Route::controller(\App\Http\Controllers\User\ProfileController::class)->group(function () {
        Route::get('user-profile', 'profile')->name('user-profile');
        Route::view('change-password', 'user.account.change_password')->name('change-password');
        Route::put('update-password', 'updatePassword')->name('update-password');
        Route::put('update-initial-password', 'updateInitialPassword')->name('update-initial-password');
        Route::view('change-mobile', 'user.account.change_mobile')->name('change-mobile');
        Route::put('update-mobile', 'updateMobile')->name('update-mobile');
        Route::view('verify-user-mobile', 'user.account.verify_mobile')->name('verify-user-mobile');
        Route::post('send-mobile-verification-code', 'sendVerificationCode')->name('send-mobile-verification-code');
        Route::post('verify-mobile-verification-code', 'verifyMobileCode')->name('verify-mobile-verification-code');
        Route::get('user-logout', 'logout')->name('user-logout');
    });
    // Manage Order
    Route::controller(\App\Http\Controllers\User\OrderController::class)->group(function () {
        Route::get('order-list', 'orderList')->name('order-list');
        Route::get('order-details/{invoice}', 'orderDetails')->name('order-details');
    });

    Route::controller(SslCommerzPaymentController::class)->as('sslcommerz.')->group(function () {
        Route::any('pay-now', 'index')->name('pay-now');
        Route::any('success', 'success');
        Route::any('fail', 'fail');
        Route::any('cancel', 'cancel');
        Route::any('ipn', 'ipn');
    });
});
// Social Login Part
Route::controller(\App\Http\Controllers\SocialLoginController::class)->group(function () {
    // Facebook Login
    Route::get('auth/facebook', 'redirectToFacebook')->name('facebook.login');
    Route::get('auth/facebook/callback', 'facebookCallback')->name('facebook.callback');
    // Google(Gmail) Login
    Route::get('auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('auth/google/callback', 'googleCallback')->name('google.callback');
    // Instagram Login
    Route::get('auth/instagram', 'redirectToInstagram')->name('instagram.login');
    Route::get('auth/instagram/callback', 'instagramCallback')->name('instagram.callback');
});

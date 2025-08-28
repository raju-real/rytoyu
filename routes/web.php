<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\User\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;
use BotMan\BotMan\BotMan;
use App\Services\ProductChatbotConversation;
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
    Route::view('privacy-policy','user.pages.privacy_policy')->name('privacy-policy');
    Route::view('terms-and-conditions','user.pages.terms_conditions')->name('terms-and-conditions');
    // Authentication Part
    Route::get('register', 'userRegisterPage')->name('register');
    Route::post('user-register', 'userRegistration')->name('user-register');
    Route::get('login', 'userLoginPage')->name('login');
    Route::post('user-login', 'userLogin')->name('user-login');

    // Seller Registration
    Route::view('seller-registration-form','user.pages.seller_registration')->name('seller-registration-form');
    Route::post('seller-register','sellerRegister')->name('seller-register');
    // Team Join request
    Route::view('join-request','user.pages.join_request')->name('join-request');
    Route::post('send-join-request','sendJoinRequest')->name('send-join-request');
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
        // Manage wishlists
        Route::get('wishlists','wishlists')->name('wishlists');
        Route::post('add-to-wishlist','addToWishList')->name('add-to-wishlist');
        Route::get('delete-wish-list-item/{item_id}','deleteWishListItem')->name('delete-wish-list-item');
    });
});
// User Part
Route::middleware('auth')->group(function () {
    // Manage Profile
    Route::controller(\App\Http\Controllers\User\ProfileController::class)->group(function () {
        Route::get('user-profile', 'profile')->name('user-profile');
        Route::put('update-user-profile', 'updateUserProfile')->name('update-user-profile');
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
        Route::get('order-details/{unique_id}', 'orderDetails')->name('order-details');
        Route::get('user-order-invoice/{unique_id}', 'orderInvoice')->name('user-order-invoice');
        Route::get('submit-review/{combine_id}','submitReview')->name('submit-review');
        Route::post('store-review/{order_product_id}','storeReview')->name('store-review');
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

Route::post('/chat', [ChatbotController::class, 'handleChat'])->name('chat');


Route::match(['get', 'post'], '/botman', function () {
    \Log::info('BotMan request received', request()->all());

    $botman = app('botman');

    // Add simple test response
    $botman->hears('test', function(BotMan $bot) {
        $bot->reply('Test successful!');
    });

    // Greetings
    $botman->hears('hello|hi|hey|hola|greetings', function (BotMan $bot) {
        $bot->startConversation(new ProductChatbotConversation());
    });

    // Product search
    $botman->hears('.*(product|products|item|items).*', function (BotMan $bot) {
        $bot->startConversation(new ProductChatbotConversation());
    });

    // Price search
    $botman->hears('.*(price|cost|expensive|cheap|affordable).*', function (BotMan $bot) {
        $bot->startConversation(new ProductChatbotConversation());
    });

    // Default response
    $botman->fallback(function (BotMan $bot) {
        \Log::info('Fallback response triggered');
        $bot->reply('I can help you find products. Try asking about products by name or price. Type "hello" to start!');
    });

    $botman->listen();
});

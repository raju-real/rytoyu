<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::view('admin', 'admin.admin_login');
Route::post('admin-login', \App\Http\Controllers\Admin\AdminLogin::class)->name('admin-login');

Route::group(['as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'profile')->name('profile');
        Route::put('update-profile', 'updateProfile')->name('update-profile');
        Route::get('shop-info', 'shopInfo')->name('shop-info');
        Route::put('update-shop-info', 'updateShopInfo')->name('update-shop-info');
        Route::view('mobile-verification', 'admin.profile.verify_mobile')->name('mobile-verification');
        Route::post('send-verification-code', 'sendVerificationCode')->name('send-verification-code');
        Route::post('verify-code', 'verifyCode')->name('verify-code');
    });
    //Attributes
    Route::middleware('admin')->group(function () {
        Route::resource('product-types', \App\Http\Controllers\Admin\ProductTypeController::class);
        Route::controller(\App\Http\Controllers\Admin\ProductTypeController::class)->group(function () {
            Route::put('update-product-type-status/{id}', 'updateProductTypeStatus')->name('update-product-type-status');
            Route::post('sort-product-types', 'sortProductTypes')->name('sort-product-types');
        });
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::controller(\App\Http\Controllers\Admin\CategoryController::class)->group(function () {
            Route::put('update-category-status/{id}', 'updateCategoryStatus')->name('update-category-status');
            Route::post('sort-categories', 'sortCategories')->name('sort-categories');
        });
        Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class);
        Route::controller(\App\Http\Controllers\Admin\SubCategoryController::class)->group(function () {
            Route::put('update-subcategory-status/{id}', 'updateSubCategoryStatus')->name('update-subcategory-status');
            Route::post('sort-subcategories', 'sortSubCategories')->name('sort-subcategories');
        });
        Route::resource('sub-subcategories', \App\Http\Controllers\Admin\SubSubcategoryController::class);
        Route::controller(\App\Http\Controllers\Admin\SubSubcategoryController::class)->group(function () {
            Route::put('update-sub-subcategory-status/{id}', 'updateSubSubCategoryStatus')->name('update-sub-subcategory-status');
            Route::post('sort-sub-subcategories', 'sortSubSubCategories')->name('sort-sub-subcategories');
        });
        Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
        Route::controller(\App\Http\Controllers\Admin\BrandController::class)->group(function () {
            Route::put('update-brand-status/{id}', 'updateBrandStatus')->name('update-brand-status');
            Route::post('sort-brands', 'sortBrands')->name('sort-brands');
        });
        Route::resource('sizes', \App\Http\Controllers\Admin\SizeController::class);
        Route::resource('colors', \App\Http\Controllers\Admin\ColorController::class);
        Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
    });
    //Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::controller(\App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('get-product-variants/{id}', 'productVariants')->name('get-product-variants');
        Route::get('get-product-variants-data', 'getProductVariantsData')->name('get-product-variants-data');
        Route::put('update-product-status/{id}', 'updateProductStatus')->name('update-product-status');
    });
    //Inventory
    Route::controller(\App\Http\Controllers\Admin\InventoryController::class)->group(function () {
        Route::get('product-stock-status', 'productStockStatus')->name('product-stock-status');
    });
    // Sellers
    Route::resource('sellers', \App\Http\Controllers\Admin\SellerController::class);
    Route::controller(\App\Http\Controllers\Admin\SellerController::class)->group(function () {
        Route::put('update-seller-status/{id}', 'updateSellerStatus')->name('update-seller-status');
        Route::put('update-seller-request-status/{id}', 'updateSellerRequestStatus')->name('update-seller-request-status');
    });
    // Settings
    Route::controller(\App\Http\Controllers\Admin\SettingController::class)->group(function () {
        Route::get('site-settings', 'siteSettings')->name('site-settings');
        Route::put('update-site-settings', 'updateSiteSettings')->name('update-site-settings');
    });
    // Webpage Manage Section
    // Sliders
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::controller(\App\Http\Controllers\Admin\SliderController::class)->group(function () {
        Route::put('update-slider-status/{id}', 'updateSliderStatus')->name('update-slider-status');
        Route::post('sort-sliders', 'sortSliders')->name('sort-sliders');
        Route::get('slider-products/{slug}', 'sliderProducts')->name('slider-products');
        Route::get('slider-wise-products/{slider_id}', 'getSliderWiseProducts')->name('slider-wise-products');
        Route::post('add-slider-product', 'addSliderProduct')->name('add-slider-product');
        Route::post('update-slider-product-sorting', 'updateSliderProductSorting')->name('update-slider-product-sorting');
        Route::delete('delete-slider-product', 'deleteSliderProduct')->name('delete-slider-product');
    });
    // Announcements
    Route::resource('announcements',\App\Http\Controllers\Admin\AnnouncementController::class);
    // Homepage section Manage
    Route::controller(\App\Http\Controllers\WebPageManageController::class)->group(function () {
       // New in section
        Route::get('new-in-products','newInProducts')->name('new-in-products');
        Route::get('get-new-in-products','getNewInProducts')->name('get-new-in-products');
        Route::post('add-new-in-product','addNewInProducts')->name('add-new-in-product');
        Route::post('update-new-in-product-sorting', 'updateNewInProductSorting')->name('update-new-in-product-sorting');
        Route::delete('delete-new-in-product', 'deleteNewInProduct')->name('delete-new-in-product');
        Route::get('manage-product-types','manageProductType')->name('manage-product-types');
        Route::get('product-types-category-bound/{product_type_slug}','productTypeCategoryBound')->name('product-types-category-bound');
        Route::post('bound-category-on-product-type/{type_id}','boundCategoryOnProductType')->name('bound-category-on-product-type');
        Route::get('latest-offers','latestOffers')->name('latest-offers');
        Route::get('get-latest-offer-products','getLatestOfferProducts')->name('get-latest-offer-products');
        Route::get('search-own-discount-products', 'searchLatestOfferProduct')->name('search-own-discount-products');
        Route::post('add-latest-offer-product','addLatestOfferProducts')->name('add-latest-offer-product');
        Route::post('update-latest-offer-product-sorting', 'updateLatestOfferProductSorting')->name('update-latest-offer-product-sorting');
        Route::delete('delete-latest-offer-product', 'deleteLatestOfferProduct')->name('delete-latest-offer-product');
    });

    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        \Illuminate\Support\Facades\Session::reflash();
        return redirect()->route('home');
    })->name('logout');
});

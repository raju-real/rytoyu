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
    //Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::view('get-product-variant', 'admin.products.product_variant')->name('get-product-variant');
    Route::controller(\App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('get-product-variants/{id}', 'productVariants')->name('get-product-variants');
        Route::get('get-product-variants-data', 'getProductVariantsData')->name('get-product-variants-data');
        Route::put('update-product-status/{id}', 'updateProductStatus')->name('update-product-status');
    });
    //Inventory
    Route::controller(\App\Http\Controllers\Admin\InventoryController::class)->group(function () {
       Route::get('product-stock-status','productStockStatus')->name('product-stock-status');
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
    Route::controller(\App\Http\Controllers\Admin\SectionController::class)->group(function () {
       Route::get('sections','sectionList')->name('sections');
       Route::get('add-section','addSection')->name('add-section');
       Route::post('store-section','storeSection')->name('store-section');
       Route::post('sort-section','sortSection')->name('sort-section');
       Route::get('edit-section/{slug}','editSection')->name('edit-section');
       Route::put('update-section/{slug}','updateSection')->name('update-section');
       Route::delete('delete-section/{id}','deleteSection')->name('delete-section');
       Route::put('update-section-status/{id}','updateSectionStatus')->name('update-section-status');
    });

    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        \Illuminate\Support\Facades\Session::reflash();
        return redirect()->route('home');
    })->name('logout');
});

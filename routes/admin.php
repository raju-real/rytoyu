<?php

use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SellerOrderManageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\WebPageManageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DeliveryChargeController;
use App\Http\Controllers\Admin\SubSubcategoryController;
use App\Http\Controllers\Admin\AdminOrderManageController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::view('admin', 'admin.admin_login');
Route::post('admin-login', AdminLogin::class)->name('admin-login');

// Group route for administrator, admin and seller
// ============================================================================

Route::group(['as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    // Common for administrator, admin and seller
    // =========================================================================
    Route::view('permission-denied', 'admin.permission_denied')->name('permission-denied');
    Route::controller(DashboardController::class)->group(function () {
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

    //Products
    Route::resource('products', ProductController::class);
    Route::controller(ProductController::class)->group(function () {
        Route::get('get-product-variants/{id}', 'productVariants')->name('get-product-variants');
        Route::get('get-product-variants-data', 'getProductVariantsData')->name('get-product-variants-data');
        Route::put('update-product-status/{id}', 'updateProductStatus')->name('update-product-status');
    });
    // =========================================================================
    // End of Group route for administrator, admin and seller

    // Start of only for administrator routes
    // =========================================================================
    Route::middleware('administrator')->group(function () {
        //.......
    });
    // =========================================================================
    // End of only for administrator routes

    // Start of only for admin routes
    // =========================================================================
    Route::middleware('admin')->group(function () {
        //.......
    });
    // =========================================================================
    // End of only for admin routes

    // Start of only for seller routes
    // =========================================================================
    Route::middleware('seller')->group(function () {
        Route::controller(SellerOrderManageController::class)->group(function () {
            Route::get('seller-orders', 'orderList')->name('seller-orders');
            Route::get('seller-order-info/{unique_id}', 'orderProducts')->name('seller-order-info');
            Route::get('seller-order-invoice/{unique_id}', 'orderInvoice')->name('seller-order-invoice');
            Route::get('seller-change-order-status/{unique_id}', 'changeOrderStatus')->name('seller-change-order-status');
            Route::get('seller-update-order-status', 'updateOrderStatus')->name('seller-update-order-status');
            Route::get('seller-update-order-status-all', 'updateOrderStatusAll')->name('seller-update-order-status-all');
        });
    });
    // =========================================================================
    // End of only for seller routes

    // Start of only for administrator and admin (with permission check)
    // =========================================================================
    Route::middleware('administrator_admin')->group(function () {
        //Attributes
        Route::resource('product-types', ProductTypeController::class);
        Route::controller(ProductTypeController::class)->group(function () {
            Route::put('update-product-type-status/{id}', 'updateProductTypeStatus')->name('update-product-type-status');
            Route::post('sort-product-types', 'sortProductTypes')->name('sort-product-types');
        });
        Route::resource('categories', CategoryController::class);
        Route::controller(CategoryController::class)->group(function () {
            Route::put('update-category-status/{id}', 'updateCategoryStatus')->name('update-category-status');
            Route::post('sort-categories', 'sortCategories')->name('sort-categories');
        });
        Route::resource('subcategories', SubCategoryController::class);
        Route::controller(SubCategoryController::class)->group(function () {
            Route::put('update-subcategory-status/{id}', 'updateSubCategoryStatus')->name('update-subcategory-status');
            Route::post('sort-subcategories', 'sortSubCategories')->name('sort-subcategories');
        });
        Route::resource('sub-subcategories', SubSubcategoryController::class);
        Route::controller(SubSubcategoryController::class)->group(function () {
            Route::put('update-sub-subcategory-status/{id}', 'updateSubSubCategoryStatus')->name('update-sub-subcategory-status');
            Route::post('sort-sub-subcategories', 'sortSubSubCategories')->name('sort-sub-subcategories');
        });
        Route::resource('brands', BrandController::class);
        Route::controller(BrandController::class)->group(function () {
            Route::put('update-brand-status/{id}', 'updateBrandStatus')->name('update-brand-status');
            Route::post('sort-brands', 'sortBrands')->name('sort-brands');
        });
        Route::resource('sizes', SizeController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('units', UnitController::class);
        Route::resource('tags', TagController::class);
        // Coupon
        Route::resource('coupons', CouponController::class);
        Route::controller(CouponController::class)->group(function () {
            Route::put('update-coupon-status/{id}', 'updateCouponStatus')->name('update-coupon-status');
        });
        // Settings
        Route::controller(SettingController::class)->group(function () {
            Route::get('site-settings', 'siteSettings')->name('site-settings');
            Route::put('update-site-settings', 'updateSiteSettings')->name('update-site-settings');
            Route::resource('delivery-charges', DeliveryChargeController::class);
            Route::controller(DeliveryChargeController::class)->group(function () {
                Route::put('update-delivery-charge-status/{id}', 'updateDeliveryChargeStatus')->name('update-delivery-charge-status');
            });
        });
        Route::resource('faqs', FaqController::class);

        // Announcements
        Route::resource('announcements', AnnouncementController::class);
        // Sellers
        Route::resource('sellers', SellerController::class);
        Route::controller(SellerController::class)->group(function () {
            Route::put('update-seller-status/{id}', 'updateSellerStatus')->name('update-seller-status');
            Route::put('update-seller-request-status/{id}', 'updateSellerRequestStatus')->name('update-seller-request-status');
            Route::get('show-seller-info/{seller_code}', 'showSellerInfo')->name('show-seller-info');
            // Product
            Route::get('seller-products', 'productList')->name('seller-products');
            Route::get('seller-product/{slug}', 'sellerProduct')->name('seller-product');
            Route::get('update-product-request-status', 'updateRequestStatus')->name('update-product-request-status');
        });
        // Sliders
        Route::resource('sliders', SliderController::class);
        Route::controller(SliderController::class)->group(function () {
            Route::put('update-slider-status/{id}', 'updateSliderStatus')->name('update-slider-status');
            Route::post('sort-sliders', 'sortSliders')->name('sort-sliders');
            Route::get('slider-products/{slug}', 'sliderProducts')->name('slider-products');
            Route::get('slider-wise-products/{slider_id}', 'getSliderWiseProducts')->name('slider-wise-products');
            Route::post('add-slider-product', 'addSliderProduct')->name('add-slider-product');
            Route::post('update-slider-product-sorting', 'updateSliderProductSorting')->name('update-slider-product-sorting');
            Route::delete('delete-slider-product', 'deleteSliderProduct')->name('delete-slider-product');
        });
        // Order Manage
        Route::controller(AdminOrderManageController::class)->group(function () {
            Route::get('manage-orders', 'manageOrders')->name('manage-orders');
            Route::get('order-info/{unique_id}', 'orderProducts')->name('order-info');
            Route::get('order-summary/{unique_id}', 'orderSummary')->name('order-summary');
            Route::get('commission-logs', 'commissionLogs')->name('commission-logs');
            Route::get('order-invoice/{unique_id}', 'orderInvoice')->name('order-invoice');
            Route::get('change-order-status/{unique_id}', 'changeOrderStatus')->name('change-order-status');
            Route::get('update-order-status', 'updateOrderStatus')->name('update-order-status');
            Route::get('update-order-status-all', 'updateOrderStatusAll')->name('update-order-status-all');
        });
        //Inventory
        Route::controller(InventoryController::class)->group(function () {
            Route::get('product-stock-status', 'productStockStatus')->name('product-stock-status');
        });
        // Homepage section Manage
        Route::controller(WebPageManageController::class)->group(function () {
            // New in section
            Route::get('new-in-products', 'newInProducts')->name('new-in-products');
            Route::get('get-new-in-products', 'getNewInProducts')->name('get-new-in-products');
            Route::post('add-new-in-product', 'addNewInProducts')->name('add-new-in-product');
            Route::post('update-new-in-product-sorting', 'updateNewInProductSorting')->name('update-new-in-product-sorting');
            Route::delete('delete-new-in-product', 'deleteNewInProduct')->name('delete-new-in-product');
            Route::get('manage-product-types', 'manageProductType')->name('manage-product-types');
            Route::get('product-types-category-bound/{product_type_slug}', 'productTypeCategoryBound')->name('product-types-category-bound');
            Route::post('bound-category-on-product-type/{type_id}', 'boundCategoryOnProductType')->name('bound-category-on-product-type');
            Route::get('latest-offers', 'latestOffers')->name('latest-offers');
            Route::get('get-latest-offer-products', 'getLatestOfferProducts')->name('get-latest-offer-products');
            Route::get('search-own-discount-products', 'searchLatestOfferProduct')->name('search-own-discount-products');
            Route::post('add-latest-offer-product', 'addLatestOfferProducts')->name('add-latest-offer-product');
            Route::post('update-latest-offer-product-sorting', 'updateLatestOfferProductSorting')->name('update-latest-offer-product-sorting');
            Route::delete('delete-latest-offer-product', 'deleteLatestOfferProduct')->name('delete-latest-offer-product');
        });
    });
    // =========================================================================
    // End of Group route for administrator and admin (with permission check)

    Route::get('logout', function () {
        Auth::logout();
        Session::reflash();
        return redirect()->route('home');
    })->name('logout');

    Route::get('bulk-operation', function () {
        $order = Order::where('order_number', '0022')->first();
        $qr_data =
            "Order Details\n" .
            "-----------------------\n" .
            "Order No: " . $order->order_number . "\n" .
            "Invoice No: " . $order->invoice . "\n" .
            "Order Date: " . $order->created_at->format('d M, Y') . "\n" .
            "Customer: " . $order->customer_full_name . "\n" .
            "Mobile: " . $order->mobile . "\n" .
            "City: " . $order->city_town . "\n" .
            "Post Code: " . $order->post_code . "\n" .
            "Address: " . $order->address . "\n" .
            "Total Amount: " . number_format($order->total_order_price, 2) . " BDT";

        generateQr($qr_data, 'order_' . $order->order_number, 200, 0);
    });
});

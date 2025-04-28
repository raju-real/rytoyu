<?php

use App\Models\Admin;
use App\Models\NewInProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

if (!function_exists('successMessage')) {
    function successMessage(string $type = 'success', string $message = "Information has been saved successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('infoMessage')) {
    function infoMessage(string $type = 'info', string $message = "Information has been updated successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('deleteMessage')) {
    function deleteMessage(string $type = 'primary', string $message = "Information has been updated successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}


if (!function_exists('dangerMessage')) {
    function dangerMessage(string $type = 'danger', string $message = "Information has been deleted successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('warningMessage')) {
    function warningMessage(string $type = 'warning', string $message = "Something is wrong!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('starSign')) {
    function starSign(): string
    {
        return " <span class='text-danger'>" . " *" . "</span>";
    }
}

if (!function_exists('displayError')) {
    function displayError(string $error = "Something went wrong!"): string
    {
        return "<span class='text-danger font-weight-500'>" . $error . "</span>";
    }
}

if (!function_exists('ecommerceIcon')) {
    function ecommerceIcon(): string
    {
        return "assets/common/images/ecommerce.png";
    }
}

if (!function_exists('devLogo')) {
    function devLogo(): string
    {
        return "assets/dev/ex_logo.jpg";
    }
}

if (!function_exists('hasError')) {
    function hasError(string $fieldName): string
    {
        $errors = session()->get('errors');
        return $errors && $errors->has($fieldName) ? 'border-danger is-invalid' : '';
    }
}

if (!function_exists('commonSpinner')) {
    function commonSpinner(): string
    {
        return "<i class='fa fa-spinner fa-spin me-2 spinner d-none'></i>";
    }
}

if (!function_exists('getStatus')) {
    function getStatus(): array
    {
        return [
            (object)['value' => 'active', 'title' => 'Active'],
            (object)['value' => 'inactive', 'title' => 'In Active']
        ];
    }
}

if (!function_exists('getConfirmStatus')) {
    function getConfirmStatus(): array
    {
        return [
            (object)['value' => 'yes', 'title' => 'Yes'],
            (object)['value' => 'no', 'title' => 'No']
        ];
    }
}

if (!function_exists('webSectionFor')) {
    function webSectionFor(): array
    {
        return [
            (object)['value' => 'product', 'title' => 'Product'],
//            (object)['value' => 'category', 'title' => 'Category'],
            (object)['value' => 'campaign', 'title' => 'Campaign'],
            (object)['value' => 'advertisement', 'title' => 'Advertisement']
        ];
    }
}

if (!function_exists('isActive')) {
    function isActive($status): bool
    {
        return $status == 'active';
    }
}

if (!function_exists('isApproved')) {
    function isApproved($status): bool
    {
        return $status == 'approved';
    }
}

if (!function_exists('getRequestStatus')) {
    function getRequestStatus(): array
    {
        return [
            (object)['value' => 'pending', 'title' => 'Pending'],
            (object)['value' => 'approved', 'title' => 'Approved']
        ];
    }
}

if (!function_exists('showStatus')) {
    function showStatus($status): string
    {
        $status_badge = $status == 'active' ? 'primary' : 'danger';
        $status_text = firstUpper($status);
        return "<span class='badge badge-pill badge-soft-{$status_badge} font-size-11'>" . $status_text . "</span>";
    }
}

if (!function_exists('showRequestStatus')) {
    function showRequestStatus($status): string
    {
        $status_badge = $status == 'approved' ? 'primary' : 'warning';
        $status_text = firstUpper($status);
        return "<span class='badge badge-pill badge-soft-{$status_badge} font-size-11'>" . $status_text . "</span>";
    }
}

if (!function_exists('authAdmin')) {
    function authAdmin(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->guard('admin')->user();
    }
}

if (!function_exists('authAdminType')) {
    function authAdminType()
    {
        return auth()->guard('admin')->user()->type ?? null;
    }
}

if (!function_exists('authSellerId')) {
    function authSellerId()
    {
        return auth()->guard('admin')->user()->type == 'seller' ? auth()->user()->id : 1;
    }
}

if (!function_exists('authShopInfo')) {
    function authShopInfo()
    {
        return auth()->guard('admin')->user()->shop;
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'Y-m-d'): string
    {
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('listedOn')) {
    function listedOn(): array
    {
        return [
            (object)['value' => 'featured', 'title' => 'Featured'],
            (object)['value' => 'new-arrivals', 'title' => 'New Arrivals'],
            (object)['value' => 'best-selling', 'title' => 'Best Selling']
        ];
    }
}

if (!function_exists('imageInfo')) {
    function imageInfo($image): array
    {
        return [
            'is_image' => isImage($image),
            'extension' => fileExtension($image),
            'width' => imageWidthHeight($image)['width'],
            'height' => imageWidthHeight($image)['height'],
            'size' => $image->getSize(),
            'mb_size' => fileSizeInMB($image->getSize())
        ];
    }
}

if (!function_exists('isImage')) {
    function isImage($file): bool
    {
        return $fileType = $file->getClientMimeType();
        $text = explode('/', $fileType)[0];
        return $text == "image";

    }
}

if (!function_exists('fileExtension')) {
    function fileExtension($file): mixed
    {
        if (isset($file)) {
            return $file->getClientOriginalExtension();
        } else {
            return "Invalid file";
        }
    }
}

if (!function_exists('imageWidthHeight')) {
    function imageWidthHeight($image): array
    {
        $imageSize = getimagesize($image);
        $width = $imageSize[0];
        $height = $imageSize[1];
        return array('width' => $width, 'height' => $height);
    }
}

if (!function_exists('fileSizeInMB')) {
    function fileSizeInMB($size): mixed
    {
        if ($size > 0) {
            return number_format($size / 1048576, 2);
        }
        return $size;
    }
}

if (!function_exists('ecommerceIcon')) {
    function ecommerceIcon(): string
    {
        return 'assets/common/images/ecommerce.png';
    }
}

if (!function_exists('userAvatar')) {
    function userAvatar(): string
    {
        return 'assets/common/images/avatar.png';
    }
}


if (!function_exists('firstUpper')) {
    function firstUpper($text): string
    {
        return ucfirst($text);
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($file, string $folderName = "partial/", $size = "", $width = "", $height = ""): string
    {
        $folderPath = "assets/files/images/" . $folderName;
        File::isDirectory($folderPath) || File::makeDirectory($folderPath, 0777, true, true);
        $imageName = time() . '-' . $file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        if ((isset($height)) && (isset($width))) {
            $image->resize($width, $height);
        }
        if (isset($size)) {
            $image->filesize($size);
        }
        $image->save($folderPath . "/" . $imageName);
        return $folderPath . "/" . $imageName;
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, string $path = "files/"): string
    {
        $uniqueFileName = time() . '_' . '.' . $file->getClientOriginalExtension();
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $file->move($path, $uniqueFileName);
        return $uniqueFileName;
    }
}

if (!function_exists('segmentOne')) {
    function segmentOne(): ?string
    {
        return request()->segment(1);
    }
}

if (!function_exists('isMainMenuActive')) {
    function isMainMenuActive(string $fieldName): string
    {
        $main_menus = explode(',', $fieldName);
        return in_array(segmentOne(), $main_menus) ? 'active mm-active' : '';
    }
}

if (!function_exists('isSubMenuActive')) {
    function isSubMenuActive(string $fieldName): string
    {
        return request()->segment(1) == $fieldName ? 'active' : '';
    }
}

if (!function_exists('generateVerificationCode')) {
    function generateVerificationCode(): int
    {
        return mt_rand(100000, 999999); // Generate 6-digit code
    }
}

if (!function_exists('textLimit')) {
    function textLimit($text = "")
    {
        return Str::limit($text, 20, '...');
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($number, $format = 2): mixed
    {
        return number_format($number,$format);
    }
}

// Website helpers

if (!function_exists('megaMenus')) {
    function megaMenus()
    {
        return \App\Models\Category::with([
            'subcategories' => function ($subcategory) {
                $subcategory->where('is_mega_menu', 'yes')->active();
                $subcategory->with([
                    'sub_subcategories' => function ($sub_subcategory) {
                        $sub_subcategory->where('is_mega_menu', 'yes')->active()->select('id', 'category_id', 'subcategory_id', 'name', 'slug');
                    }
                ]);
                $subcategory->select('id', 'category_id', 'name', 'slug');
            }
        ])->active()->where('is_mega_menu', 'yes')->select('id', 'name', 'slug')->get();
    }
}

if (!function_exists('latestAnnouncements')) {
    function latestAnnouncements()
    {
        return \App\Models\Announcement::latest()->get();
    }
}

if (!function_exists('activeSliders')) {
    function activeSliders()
    {
        return \App\Models\Slider::active()->sort()->get();
    }
}

if (!function_exists('siteSettings')) {
    function siteSettings()
    {
        $jsonString = file_get_contents('assets/common/json/site_setting.json');
        return json_decode($jsonString, true);
    }
}

if (!function_exists('activeProductTypes')) {
    function activeProductTypes()
    {
        return \App\Models\ProductType::active()->select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('activeCategories')) {
    function activeCategories()
    {
        return \App\Models\Category::active()->select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('allBrands')) {
    function allBrands()
    {
        return \App\Models\Brand::select('id', 'name', 'slug', 'logo')->orderBy('name')->get();
    }
}

if (!function_exists('activeBrands')) {
    function activeBrands()
    {
        return \App\Models\Brand::active()->select('id', 'name', 'slug', 'logo')->orderBy('name')->get();
    }
}

if (!function_exists('allUnits')) {
    function allUnits()
    {
        return \App\Models\Unit::select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('allSizes')) {
    function allSizes()
    {
        return \App\Models\Size::select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('allColors')) {
    function allColors()
    {
        return \App\Models\Color::select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('allTags')) {
    function allTags()
    {
        return \App\Models\Tag::select('id', 'name', 'slug')->orderBy('name')->get();
    }
}

if (!function_exists('allSellers')) {
    function allSellers()
    {
        return Admin::with('shop')->orderBy('name')->get();
    }
}

if (!function_exists('activeSellers')) {
    function activeSellers()
    {
        return Admin::active()->approved()->get();
    }
}

if (!function_exists('sellerIdByCode')) {
    function sellerIdByCode($code)
    {
        return Admin::whereCode($code)->first()->id ?? null;
    }
}

if (!function_exists('brandIdBySlug')) {
    function brandIdBySlug($slug)
    {
        return \App\Models\Brand::whereSlug($slug)->first()->id ?? null;
    }
}

if (!function_exists('categoryIdBySlug')) {
    function categoryIdBySlug($slug)
    {
        return \App\Models\Category::whereSlug($slug)->first()->id ?? null;
    }
}

if (!function_exists('categoryNameBySlug')) {
    function categoryNameBySlug($slug)
    {
        return \App\Models\Category::whereSlug($slug)->first()->name ?? null;
    }
}

if (!function_exists('subCategoryIdBySlug')) {
    function subCategoryIdBySlug($slug)
    {
        return \App\Models\SubCategory::whereSlug($slug)->first()->id ?? null;
    }
}

if (!function_exists('subSubCategoryIdBySlug')) {
    function subSubCategoryIdBySlug($slug)
    {
        return \App\Models\SubSubcategory::whereSlug($slug)->first()->id ?? null;
    }
}

if (!function_exists('subSubCategoryNameBySlug')) {
    function subSubCategoryNameBySlug($slug)
    {
        return \App\Models\SubSubcategory::whereSlug($slug)->first()->name ?? null;
    }
}

if (!function_exists('subCategoryNameBySlug')) {
    function subCategoryNameBySlug($slug)
    {
        return \App\Models\SubCategory::whereSlug($slug)->first()->name ?? null;
    }
}

if (!function_exists('colorControl')) {
    function colorControl($style, $colorCode)
    {
        return $style . ': ' . $colorCode;
    }
}


if (!function_exists('productTagsToArray')) {
    function productTagsToArray($product_id): array
    {
        $product = \App\Models\Product::find($product_id);
        return $product->product_tags ? explode(',', $product->product_tags) : [];
    }
}

// Slug section
if (!function_exists('categorySlugById')) {
    function categorySlugById($id)
    {
        return \App\Models\Category::find($id)->slug ?? "";
    }
}

if (!function_exists('subCategorySlugById')) {
    function subCategorySlugById($id)
    {
        return \App\Models\SubCategory::find($id)->slug ?? "";
    }
}

if (!function_exists('subSubCategorySlugById')) {
    function subSubCategorySlugById($id)
    {
        return \App\Models\SubSubcategory::find($id)->slug ?? "";
    }
}

if (!function_exists('brandSlugById')) {
    function brandSlugById($id)
    {
        return \App\Models\SubSubcategory::find($id)->slug ?? "";
    }
}

if (!function_exists('productCategoryNameById')) {
    function productCategoryNameById($product_id)
    {
        $category_id = Product::find($product_id)->category_id;
        return \App\Models\Category::find($category_id)->name ?? "";
    }
}

// Website Section
if (!function_exists('getNewInProducts')) {
    function getNewInProducts()
    {
        if (\App\Models\NewInProduct::count()) {
            $product_ids = NewInProduct::sort()
                ->pluck('product_id')
                ->toArray();
            $ids_string = implode(',', $product_ids); // Convert to a comma-separated string
            return Product::whereIn('id', $product_ids)
                ->active()
                ->orderByRaw("FIELD(id, $ids_string)")
                ->take(16)
                ->select('id', 'seller_id', 'brand_id', 'product_code', 'name', 'slug', 'thumbnail_path', 'unit_price', 'discount_price')
                ->get();
        } else {
            return Product::active()
                ->latest()
                ->inRandomOrder()
                ->take(16)
                ->select('id', 'seller_id', 'brand_id', 'product_code', 'name', 'slug', 'thumbnail_path', 'unit_price', 'discount_price')
                ->get();
        }
    }
}

if (!function_exists('getProductTypes')) {
    function getProductTypes()
    {
        return \App\Models\ProductType::active()->select('id', 'name', 'slug', 'icon', 'image')->orderBy('sorting_serial')->get();
    }
}

if (!function_exists('getBrands')) {
    function getBrands()
    {
        return \App\Models\Brand::active()->select('id', 'name', 'slug', 'logo', 'image')->orderBy('sorting_serial')->get();
    }
}

// Cart section

if(! function_exists('shippingFee')) {
    function shippingFee()
    {
         return 200;
    }
}

if(! function_exists('browserId')) {
    function browserId() {
         $ip = '';
        if(isset($_COOKIE['browser_id'])) {
            $ip = $_COOKIE['browser_id'];
        }
        return $ip;
    }
}


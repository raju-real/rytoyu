<?php

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
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

if (!function_exists('webSectionFor')) {
    function webSectionFor(): array
    {
        return [
            (object)['value' => 'product', 'title' => 'Product'],
            (object)['value' => 'category', 'title' => 'Category'],
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

if(!function_exists('authAdmin')) {
    function authAdmin(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->guard('admin')->user();
    }
}

if(!function_exists('authShopInfo')) {
    function authShopInfo() {
        return auth()->guard('admin')->user()->shop;
    }
}

if(!function_exists('dateFormat')) {
    function dateFormat($date,$format = 'Y-m-d'): string
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


if(!function_exists('firstUpper')) {
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

if (!function_exists('siteSettings')) {
    function siteSettings()
    {
        $jsonString = file_get_contents('assets/common/json/site_setting.json');
        return json_decode($jsonString, true);
    }
}

if (!function_exists('activeCategories')) {
    function activeCategories()
    {
        return \App\Models\Category::active()->select('id', 'name', 'slug')->orderBy('name')->get();
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

if (!function_exists('activeSellers')) {
    function activeSellers()
    {
        return Admin::active()->approved()->get();
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

if (!function_exists('subCategoryNameBySlug')) {
    function subCategoryNameBySlug($slug)
    {
        return \App\Models\SubCategory::whereSlug($slug)->first()->name ?? null;
    }
}


if (!function_exists('productTagsToArray')) {
    function productTagsToArray($product_id): array
    {
        $product = \App\Models\Product::find($product_id);
        return $product->product_tags ? explode(',', $product->product_tags) : [];
    }
}

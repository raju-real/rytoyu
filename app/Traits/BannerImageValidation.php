<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait BannerImageValidation.
 */
trait BannerImageValidation
{
    public function bannerImageRules(Request $request,$table_name)
    {
        $rules = [];
        $messages = [];
        $bannerImages = $request->input('banner_images', []);
        $isUpdating = $request->isMethod('put') || $request->isMethod('patch'); // Check if it's an update request

        foreach ($bannerImages as $index => $image) {
            $customIndex = $index + 1; // Adjust index to start from 1

            $rules["banner_images.{$index}.is_new"] = ['required', 'in:0,1'];
            $messages["banner_images.{$index}.is_new.required"] = "Banner Image {$customIndex}: The is_new field is required.";
            $messages["banner_images.{$index}.is_new.in"] = "Banner Image {$customIndex}: The is_new field must be 0 or 1.";

            if ($isUpdating && isset($image['is_new']) && $image['is_new'] == 0) {
                $rules["banner_images.{$index}.id"] = ["required", "exists:{$table_name},id"];
                $messages["banner_images.{$index}.id.required"] = "Banner Image {$customIndex}: The image ID is required.";
                $messages["banner_images.{$index}.id.exists"] = "Banner Image {$customIndex}: The selected image ID does not exist.";

                $rules["banner_images.{$index}.image"] = ['nullable', 'sometimes', 'image', 'mimes:jpeg,jpg,png', 'dimensions:width=775,height=230', 'max:1024'];
                $messages["banner_images.{$index}.image.mimes"] = "Banner Image {$customIndex}: The image must be a file of type: jpeg, jpg, png.";
                $messages["banner_images.{$index}.image.dimensions"] = "Banner Image {$customIndex}: The image must be exactly 775x230 pixels.";
                $messages["banner_images.{$index}.image.max"] = "Banner Image {$customIndex}: The image must not be larger than 1024 KB.";
            } elseif (isset($image['is_new']) && $image['is_new'] == 1) {
                $rules["banner_images.{$index}.image"] = ['required', 'image', 'mimes:jpeg,jpg,png', 'dimensions:width=775,height=230', 'max:1024'];
                $messages["banner_images.{$index}.image.required"] = "Banner Image {$customIndex}: The image is required.";
            }
        }

        return ['rules' => $rules, 'messages' => $messages];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\SubCategory;
use App\Models\SubSubcategory;
use App\Rules\DiscountPriceRule;
use App\Rules\PriceValidateRule;
use App\Rules\ProductColorRule;
use App\Rules\ProductSizeRule;
use App\Rules\ProductTagRule;
use App\Rules\ThumbnailExistsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $recordId = $this->route('product') ? $this->route('product') : null;
        $isUpdating = $this->isMethod('put'); // Check if it's a PUT request

        $rules = [
            'product_code' => [
                'required',
                'max:10',
                Rule::unique('products', 'product_code')->whereNull('deleted_at')->ignore($recordId)
            ],
            'name' => ['required', 'string', 'max:191'],
            'product_type' => ['required', 'int', 'exists:product_types,id'],
            'category' => ['required', 'int', 'exists:categories,id'],
            'subcategory' => ['nullable', 'sometimes', 'int', 'exists:sub_categories,id'],
            'sub_subcategory' => ['nullable', 'sometimes', 'int', 'exists:sub_subcategories,id'],
            'brand' => ['nullable', 'sometimes', 'int', 'exists:brands,id'],
            'unit' => ['nullable', 'sometimes', 'int', 'exists:units,id'],
            'tags' => ['nullable', 'sometimes', 'array'],
            'tags.*' => ['nullable', 'sometimes', new ProductTagRule()],
            'short_description' => ['nullable', 'sometimes', 'string', 'max:2000'],
            'special_note' => ['nullable', 'sometimes', 'string', 'max:2000'],
            'video_link' => ['nullable', 'sometimes', 'string', 'url', 'max:255'],
            'product_details' => ['required', 'max:5000'],
            'product_specification' => ['nullable', 'sometimes', 'max:5000'],
            'product_compare' => ['nullable', 'sometimes', 'max:5000'],
            'product_thumbnail' => $isUpdating
                ? ['nullable', 'image', 'mimes:jpg,jpeg,png', 'dimensions:width=375,height=480', 'max:1024', new ThumbnailExistsRule($recordId)]
                : ['required', 'image', 'mimes:jpg,jpeg,png', 'dimensions:width=375,height=480', 'max:1024'],


            'is_refundable' => ['required', 'in:0,1'],
            'is_exchangeable' => ['required', 'in:0,1'],
            'listed_on' => ['nullable', 'sometimes', 'in:featured,new-arrivals,best-selling'],
            'status' => ['required', 'in:active,inactive'],
            'warranty' => ['nullable', 'sometimes', 'max:1000']
        ];

        // Validation for variants
        $variants = $this->input('variants', []);
        // Loop through each variant to define the rules
        foreach ($variants as $index => $variant) {
            $rules["variants.{$variant['index_no']}.is_new"] = ['required', 'in:0,1'];
            $rules["variants.{$variant['index_no']}.variant_id"] = ($isUpdating && $variant['is_new'] == 0) ? ['required', 'exists:product_variants,id'] : ['nullable'];
            $rules["variants.{$variant['index_no']}.is_default"] = ['nullable', 'in:0,1'];
            $rules["variants.{$variant['index_no']}.size"] = ['nullable', 'exists:sizes,id'];
            $rules["variants.{$variant['index_no']}.color"] = ['nullable', 'exists:colors,id'];
            $rules["variants.{$variant['index_no']}.unit_price"] = ['required', 'numeric', 'gt:0'];
            $rules["variants.{$variant['index_no']}.discount_price"] = [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($index, $variants) {
                    $unitPrice = $variants[$index]['unit_price'] ?? null;
                    if ($unitPrice !== null && $value >= $unitPrice) {
                        $fail("The discount price must be less than the unit price for variant " . ($index + 1));
                    }
                },
            ];
            $rules["variants.{$variant['index_no']}.inventory"] = [
                'required',
                'int',
                'min:0'
            ];
        }

        // Validation for images
        $images = $this->input('images', []);
        foreach ($images as $image) {
            $rules["images.{$image['index_no']}.is_new"] = ['required', 'in:0,1'];
            $rules["images.{$image['index_no']}.image_id"] = ($isUpdating && $image['is_new'] == 0) ? ['required', 'exists:product_images,id'] : ['nullable'];
            if ($isUpdating && $image['is_new'] == 1) {
                $rules["images.{$image['index_no']}.image"] = ['required', 'image', 'mimes:jpeg,jpg,png', 'dimensions:width=375,height=480', 'max:1024'];
            } elseif ($isUpdating && $image['is_new'] == 0) {
                $rules["images.{$image['index_no']}.image"] = ['nullable', 'sometimes', 'image', 'mimes:jpeg,jpg,png', 'dimensions:width=375,height=480', 'max:1024'];
            } elseif (!$isUpdating && $image['is_new'] == 1) {
                $rules["images.{$image['index_no']}.image"] = ['required', 'image', 'mimes:jpeg,jpg,png', 'dimensions:width=375,height=480', 'max:1024'];
            }

        }

        return $rules;
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            $categoryId = $data['category_id'] ?? null;
            $subcategoryId = $data['subcategory_id'] ?? null;
            $subSubcategoryId = $data['subcategory_id'] ?? null;

            if ($categoryId && !$this->subcategoryBelongsToCategory($subcategoryId, $categoryId)) {
                $validator->errors()->add("subcategory_id", "The selected subcategory does not belong to the specified category.");
            }

            if ($subcategoryId && !$this->subSubcategoryBelongsToSubCategory($subSubcategoryId, $subcategoryId, $categoryId)) {
                $validator->errors()->add("sub_subcategory_id", "The selected sub subcategory does not belong to the specified category or subcategory.");
            }

            // Validate remaining variants
            $variants = collect($this->input('variants', []))
                ->filter(fn($variant) => !isset($variant['is_deleted']) || !$variant['is_deleted']);

            if ($variants->isEmpty()) {
                $validator->errors()->add('need_one_variant', 'At least one variant is required.');
            }

            $defaultCount = $variants->where('is_default', 1)->count();
            if ($defaultCount < 1 || $defaultCount > 1) {
                $validator->errors()->add('min_max_one_default', 'Exactly one variant must be set as default.');
            }
        });
    }


    protected function subcategoryBelongsToCategory($subcategoryId, $categoryId)
    {
        return SubCategory::where('id', $subcategoryId)->where('category_id', $categoryId)->exists();
    }

    protected function subSubcategoryBelongsToSubCategory($subSubcategoryId, $subcategoryId, $categoryId)
    {
        return SubSubcategory::where('id', $subSubcategoryId)->where('category_id', $categoryId)->where('subcategory_id', $subcategoryId)->exists();
    }

    public function messages()
    {
        return [
            'variants.*.size.required' => 'The size field is required for variant :position.',
            'variants.*.color.required' => 'The color field is required for variant :position.',
            'variants.*.size.exists' => 'The selected size for variant :position is invalid.',
            'variants.*.color.exists' => 'The selected color for variant :position is invalid.',
            'variants.*.unit_price.required' => 'Unit price is required for variant :position.',
            'variants.*.unit_price.gt' => 'Unit price must be greater than 0 for variant :position.',
            'variants.*.discount_price.required' => 'Discount price is required for variant :position.',
            'variants.*.discount_price.numeric' => 'The discount price must be a number for variant :position.',
            'variants.*.discount_price.min' => 'Discount price must be at least 0 for variant :position.',
            'variants.*.inventory.required' => 'Inventory is required for variant :position.',
            'variants.*.inventory.int' => 'The discount price must be a number for variant :position.',
            'variants.*.inventory.min' => 'Inventory must be at least 0 for variant :position.',
            'images.*.image.required' => 'An image is required for the uploaded field at position :position.',
            'images.*.image.image' => 'The file must be a valid image at position :position.',
            'images.*.image.mimes' => 'The image must be of type: jpeg, jpg, png at position :position.',
            'images.*.image.max' => 'The image size must not exceed 1MB at position :position.',
        ];
    }
}

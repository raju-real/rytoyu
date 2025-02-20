<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class ThumbnailExistsRule implements Rule
{
    protected $recordId;

    public function __construct($recordId)
    {
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        $product = Product::find($this->recordId);

        // Check if the product exists and has a thumbnail path
        return $product && ($value || (!empty($product->thumbnail_path) && file_exists($product->thumbnail_path)));
    }

    public function message()
    {
        return 'The :attribute is required if no existing thumbnail is found.';
    }
}

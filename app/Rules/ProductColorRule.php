<?php

namespace App\Rules;

use App\Models\Color;
use Illuminate\Contracts\Validation\Rule;

class ProductColorRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $colors = explode(',', $value);
        foreach ($colors as $color) {
            if (Color::whereName($color)->doesntExist() || strlen($color) > 50) {
                return false;
            }
        }
        if (strlen($value) > 450) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute colors must be valid and  not exceed 50 characters each and the total length must not exceed 450 characters.';
    }
}

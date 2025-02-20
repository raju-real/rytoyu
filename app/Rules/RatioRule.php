<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RatioRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if value is numeric
        if (!is_numeric($value)) {
            return false;
        }
        // Check format: Max 3 digits before decimal, max 2 digits after decimal
        if (preg_match('/^\d{1,3}(\.\d{1,2})?$/', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a numeric value with up to 3 digits before the decimal point and up to 2 digits after.';
    }
}

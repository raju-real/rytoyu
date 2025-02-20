<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiscountPriceRule implements Rule
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
    public function passes($attribute, $value): bool
    {
        $unitPrice = request()->input('unit_price', 0); // Get unit_price input or default to 0
        return $value >= 0 && $value < $unitPrice && $unitPrice > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The Discount Price must be less than unit price and greater than or equal to 0.';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PriceValidateRule implements Rule
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
        // Validate if value is numeric (integer or float)
        if (!is_numeric($value)) {
            return false;
        }
        return  $this->isValidFormat($value);
    }

    protected function isValidFormat($value): bool|int
    {
        // Validate format: up to 8 digits before decimal and up to 2 digits after decimal
        return preg_match('/^\d{1,8}(\.\d{1,2})?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute should on before decimal 8 and after decimal 2 digit.';
    }
}

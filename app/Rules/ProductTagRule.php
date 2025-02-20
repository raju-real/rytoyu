<?php

namespace App\Rules;

use App\Models\Tag;
use Illuminate\Contracts\Validation\Rule;

class ProductTagRule implements Rule
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
        $tags = explode(',', $value);
        foreach ($tags as $tag) {
            if (Tag::whereName($tag)->doesntExist() || strlen($tag) > 100) {
                return false;
            }
        }
        if (strlen($value) > 2000) {
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
        return 'The :attribute tags must not exceed 50 characters each and the total length must not exceed 450 characters.';
    }
}

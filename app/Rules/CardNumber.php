<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CardNumber implements Rule
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
        // Remove spaces from the value
        $value = str_replace(' ', '', $value);
        
        // Check if the value is exactly 16 digits
        return preg_match('/^\d{16}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid card number in the format xxxx xxxx xxxx xxxx.';
    }
}

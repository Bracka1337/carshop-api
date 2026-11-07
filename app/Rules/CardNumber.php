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
        if (! is_string($value)) {
            return false;
        }

        return preg_match('/^\d{16}$/', str_replace(' ', '', $value)) === 1;
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

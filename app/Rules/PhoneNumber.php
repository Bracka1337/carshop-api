<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        $regex = '/^\+(?:[0-9] ?){6,14}[0-9]$/';
        return preg_match($regex, $value);
    }

    public function message()
    {
        return 'The phone number must be a valid international number.';
    }
}

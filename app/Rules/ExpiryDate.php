<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExpiryDate implements Rule
{
    public function passes($attribute, $value)
    {
         list($month, $year) = explode('/', $value);

        $year = '20' . $year;

        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($year > $currentYear || ($year == $currentYear && $month >= $currentMonth)) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'The expiry date must be a valid future date.';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExpiryDate implements Rule
{
    public function passes($attribute, $value)
    {
        if (! is_string($value) || preg_match('/^(\d{2})\/(\d{2})$/', $value, $parts) !== 1) {
            return false;
        }

        [, $month, $year] = $parts;
        $year = '20'.$year;

        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($year > $currentYear || ($year == $currentYear && $month >= $currentMonth)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'The expiry date must be a valid future date.';
    }
}

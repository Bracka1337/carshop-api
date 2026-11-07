<?php

namespace App\Http\Requests\Checkout;

use App\Rules\CardNumber;
use App\Rules\ExpiryDate;
use Illuminate\Foundation\Http\FormRequest;

class CardPaymentRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', new CardNumber],
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', new ExpiryDate],
            'cvv' => ['required', 'digits:3'],
        ];
    }
}

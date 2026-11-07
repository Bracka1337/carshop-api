<?php

namespace App\Http\Requests\Checkout;

use App\Enums\DeliveryMethod;
use App\Enums\PaymentMethod;
use App\Rules\AlphaOnly;
use App\Rules\PhoneNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'f_name' => ['required', 'string', 'max:255', new AlphaOnly],
            'l_name' => ['required', 'string', 'max:255', new AlphaOnly],
            'your_email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'addr_line_1' => 'required|string|max:255',
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'delivery_method' => ['required', Rule::enum(DeliveryMethod::class)],
            'phone' => ['required', 'string', 'max:15', new PhoneNumber],
            'm_name' => 'nullable|string|max:255',
            'addr_line_2' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'vat_number' => 'nullable|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [
            'f_name.required' => 'The first name is required.',
            'f_name.string' => 'The first name must be a string.',
            'f_name.max' => 'The first name may not be greater than 255 characters.',
            'm_name.string' => 'The middle name must be a string.',
            'm_name.max' => 'The middle name may not be greater than 255 characters.',
            'l_name.required' => 'The last name is required.',
            'l_name.string' => 'The last name must be a string.',
            'l_name.max' => 'The last name may not be greater than 255 characters.',
            'your_email.required' => 'The email address is required.',
            'your_email.email' => 'The email address must be a valid email.',
            'your_email.max' => 'The email address may not be greater than 255 characters.',
            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 255 characters.',
            'city.required' => 'The city is required.',
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'addr_line_1.required' => 'The address line 1 is required.',
            'addr_line_1.string' => 'The address line 1 must be a string.',
            'addr_line_1.max' => 'The address line 1 may not be greater than 255 characters.',
            'addr_line_2.string' => 'The address line 2 must be a string.',
            'addr_line_2.max' => 'The address line 2 may not be greater than 255 characters.',
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'company_email.email' => 'The company email must be a valid email.',
            'company_email.max' => 'The company email may not be greater than 255 characters.',
            'company_name.string' => 'The company name must be a string.',
            'company_name.max' => 'The company name may not be greater than 255 characters.',
            'vat_number.string' => 'The VAT number must be a string.',
            'vat_number.max' => 'The VAT number may not be greater than 255 characters.',
            'payment_method.required' => 'The payment method is required.',
            'payment_method.enum' => 'Choose a payment method.',
            'delivery_method.required' => 'The delivery method is required.',
            'delivery_method.enum' => 'Choose a delivery method.',
        ];
    }
}

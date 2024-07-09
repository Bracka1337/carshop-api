<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    //  */
    public function rules(): array
    {
        return [
            'category' => 'required|string',
            'brand' => 'required|string',
            'price_from' => 'required|numeric',
            'price_to' => 'required|numeric|gte:price_from', 
            'size' => 'required|string',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'price_to.gte' => 'The price to must be greater than or equal to the price from.',
        ];
    }
}

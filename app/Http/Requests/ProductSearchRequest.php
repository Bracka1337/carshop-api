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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'diameter' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'et' => 'nullable|numeric',
            'cb' => 'nullable|numeric',
            'bolt' => 'nullable|integer',
            'bolt_diameter' => 'nullable|numeric',
            'type' => 'nullable|string',
            'brand' => 'nullable|exists:brands,id',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|gte:price_from',
            'order' => 'nullable|in:price_asc,price_desc,brand_asc,brand_desc',
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

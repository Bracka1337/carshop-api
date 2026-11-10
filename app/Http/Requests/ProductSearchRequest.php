<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'diameter' => 'sometimes|nullable|numeric',
            'width' => 'sometimes|nullable|numeric',
            'type' => 'sometimes|nullable|string',
            'brand' => 'sometimes|nullable|exists:brands,id',
            'price_from' => 'sometimes|nullable|numeric|min:0',
            // gte fails when price_from is missing, so only compare when both are given.
            'price_to' => array_filter(['sometimes', 'nullable', 'numeric', 'min:0', $this->filled('price_from') ? 'gte:price_from' : null]),
            'order' => 'sometimes|nullable|in:price_asc,price_desc,brand_asc,brand_desc',
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

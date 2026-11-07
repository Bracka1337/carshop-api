<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string', 'confirmed', 'min:7', 'max:16'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:32'],
            'phone_nr' => ['required', 'string', 'min:8', 'max:32'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'business_name' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url',
        ];
    }
}

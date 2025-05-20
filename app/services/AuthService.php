<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'business_name' => $data['business_name'] ?? null,
            'logo_url' => $data['logo_url'] ?? null,
        ]);
    }
}

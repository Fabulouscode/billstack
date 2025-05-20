<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, AuthService $authService): JsonResponse
    {
    
        $user = $authService->register($request->validated());

         return $this->jsonResponse(HTTP_CREATED, 'Registration was successful. A validation otp has been sent to your email');

    }
}

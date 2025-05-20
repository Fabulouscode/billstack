<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\GeneratesAuthAccessCredentials;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use GeneratesAuthAccessCredentials;

    public function register(RegisterUserRequest $request, AuthService $authService): JsonResponse
    {
        $authService->register($request->validated());

         return $this->jsonResponse(HTTP_CREATED, 'Registration was successful. A validation otp has been sent to your email');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate(function ($request) {
            return $this->getAuthenticatedUser($request);
        });

        [$accessToken, $expiresAt] = $this->generateAccessCredentialsFor($user);

        return $this->jsonResponse(HTTP_SUCCESS, 'Login successful', [
            'token' => $accessToken,
            'expires_at' => $expiresAt,
            'user' => new UserResource($user),
        ]);
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();

        [$accessToken, $expiresAt] = $this->generateAccessCredentialsFor($user);

        return $this->jsonResponse(HTTP_SUCCESS, 'Access token refreshed', [
            'token' => $accessToken,
            'expires_at' => $expiresAt,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->jsonResponse(HTTP_SUCCESS, 'User logged out successfully.');
    }

    private function getAuthenticatedUser(LoginRequest $request): ?User
    {
        if (! $user = User::where('email', $request->email)->first()) {
            return null;
        }

        return Hash::check($request->password, $user->password) ? $user : null;
    }
}

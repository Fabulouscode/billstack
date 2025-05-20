<?php

namespace App\Http\Controllers;

use App\Enums\OtpTypeEnum;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OTPController extends Controller
{
    public function verifyEmail(Request $request, OtpService $otpService)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'User not found.']);
        }

        $otpService->verify($user, $request->otp, OtpTypeEnum::EMAIL);

        return $this->jsonResponse(HTTP_SUCCESS, 'Email verified successfully.');
    }
}


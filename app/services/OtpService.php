<?php

namespace App\Services;

use App\Enums\OtpTypeEnum;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OtpService
{
    public function verify(User $user, string $otpInput, OtpTypeEnum $type): void
    {
        $otp = Otp::where('user_id', $user->id)
            ->where('type', $type->value)
            ->latest()
            ->first();

        if (!$otp) {
            throw ValidationException::withMessages(['otp' => 'OTP not found.']);
        }

        if ($otp->expires_at->isPast()) {
            throw ValidationException::withMessages(['otp' => 'OTP has expired.']);
        }

        if (!Hash::check($otpInput, $otp->otp_code)) {
            throw ValidationException::withMessages(['otp' => 'Invalid OTP.']);
        }

        $user->email_verified_at = now();
    
        $user->save();

        $otp->delete();
    }
}

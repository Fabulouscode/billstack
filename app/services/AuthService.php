<?php

namespace App\Services;

use App\Enums\OtpTypeEnum;
use App\Jobs\SendVerificationEmail;
use App\Models\OTP;
use App\Models\User;
use App\Traits\GeneratesUuid;
use App\Utils\OtpGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthService
{
   public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'business_name' => $data['business_name'] ?? null,
                'logo_url' => $data['logo_url'] ?? null,
            ]);

            $otpCode = OtpGenerator::generateNumericOtp();

           SendVerificationEmail::dispatch($user, $otpCode);

            OTP::create([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'type' => OtpTypeEnum::EMAIL->value,
                'expires_at' => Carbon::now()->addMinutes(60),
            ]);

            return $user;
        });
    }
}

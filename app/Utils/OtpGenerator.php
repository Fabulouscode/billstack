<?php
namespace App\Utils;

class OtpGenerator
{
    /**
     * Generate a numeric OTP code.
     *
     * @param int $length Length of the OTP code. Default 6.
     * @return string
     */
    public static function generateNumericOtp(int $length = 6): string
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= random_int(0, 9);
        }
        return $otp;
    }

    /**
     * Generate an alphanumeric OTP code.
     *
     * @param int $length Length of the OTP code. Default 6.
     * @return string
     */
    public static function generateAlphaNumericOtp(int $length = 6): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $otp = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, $maxIndex)];
        }

        return $otp;
    }
}

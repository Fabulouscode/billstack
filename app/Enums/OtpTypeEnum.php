<?php
namespace App\Enums;

enum OtpTypeEnum: string
{
    case EMAIL = 'email_verification';
    case PHONE = 'phone_verification';
    case TWO_FACTOR = '2fa';
}

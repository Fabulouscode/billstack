<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CARD = 'card';
    case BANK = 'bank';
    case WALLET = 'wallet';
}

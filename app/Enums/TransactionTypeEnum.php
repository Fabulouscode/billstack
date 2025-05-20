<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case SUBSCRIPTION = 'subscription';
    case INVOICE = 'invoice';
    case REFUND = 'refund';
}

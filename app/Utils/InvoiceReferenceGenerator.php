<?php

namespace App\Utils;

use App\Models\Invoice;

class InvoiceReferenceGenerator
{
    public static function generateReferenceCode(): string
    {
        $lastInvoice = Invoice::orderBy('created_at', 'desc')->first();

        if (! $lastInvoice) {
            $number = 1;
        } else {
            $lastNumber = (int) str_replace('INV-', '', $lastInvoice->reference_code);
            $number = $lastNumber + 1;
        }

        return 'INV-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}

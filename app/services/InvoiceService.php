<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceService
{
   public function createInvoiceWithItems(array $data, string $userId): Invoice
    {
        $data['user_id'] = $userId;

        return DB::transaction(function () use ($data) {
            $items = $data['items'] ?? [];
            unset($data['items']);

            $invoice = Invoice::create($data);

            if (!empty($items)) {
                $this->createInvoiceItems($invoice, $items);
            }

            return $invoice;
        });
    }

    protected function createInvoiceItems(Invoice $invoice, array $items): void
    {
        $preparedItems = array_map(function ($item) use ($invoice) {
            return [
                'id' => (string) Str::uuid(),
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'total' => $item['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $items);

        DB::table('invoice_items')->insert($preparedItems);
    }
}

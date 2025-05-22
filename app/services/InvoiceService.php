<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Http\Request;
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

    public function getFilteredInvoices(Request $request)
    {
        return Invoice::with(['client', 'items'])
            ->when($request->filled('client_name'), function ($query) use ($request) {
                $query->whereHas('client', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->client_name . '%');
                });
            })
            ->when($request->filled('reference_code'), function ($query) use ($request) {
                $query->where('reference_code', 'like', '%' . $request->reference_code . '%');
            })
            ->when($request->filled('due_date'), function ($query) use ($request) {
                $query->whereDate('due_date', $request->due_date);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            });
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatusEnum;
use App\Utils\InvoiceReferenceGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'client_id' => 'required|uuid|exists:clients,id',
            'due_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'reference_code' => 'required|string|unique:invoices,reference_code',
            'status' => 'required|string',
            'payment_link' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'reference_code' =>  InvoiceReferenceGenerator::generateReferenceCode(),
            'status' => InvoiceStatusEnum::SENT->value,
            'payment_link' => null,
            'tax' => $this->tax ?? 0.00,
        ]);
    }
}

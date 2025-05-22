<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['client', 'items'])->paginate();

        return $this->wrapJsonResponse(InvoiceResource::collection($invoices)->response(), 'Invoice retrieved successfully');
    }

    public function store(CreateInvoiceRequest $request, InvoiceService $invoiceService): JsonResponse
    {
        $invoice = $invoiceService->createInvoiceWithItems(
            $request->validated(),
            $request->user()->id
        );

        return $this->jsonResponse(HTTP_CREATED, 'Invoice created successfully', [
            'data' => new InvoiceResource($invoice),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $invoice = Invoice::with(['client', 'items'])->findOrFail($id);

        return $this->jsonResponse(
            HTTP_SUCCESS,
            'Invoice retrieved successfully',
            ['data' => new InvoiceResource($invoice)]
        );
    }
}

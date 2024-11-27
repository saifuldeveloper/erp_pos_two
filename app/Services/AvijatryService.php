<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AvijatryService
{
    protected $secret_key;
    protected $base_url;

    public function __construct()
    {
        $this->secret_key = config('services.avijatry.secret_key');
        $this->base_url = config('services.avijatry.base_url') . '/api/v1';
    }

    public function getAssignedShoes()
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->get($this->base_url . '/get-assigned-shoes');
    }

    public function approveProduct($request)
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->post($this->base_url . '/product-approved', [
            'id' => $request->id,
            'is_approved' => $request->is_approved,
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);
    }

    public function invoices()
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->get($this->base_url . '/invoices');
    }

    public function invoice($invoiceId)
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->get($this->base_url . '/invoice/' . $invoiceId);
    }

    public function approveInvoice($invoiceId, $ret)
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->post($this->base_url . '/invoice-approved', [
            'id' => $invoiceId,
            'retail_store_status' => 'Approved',
            'retail_store_remarks' => $ret['note'] ?? '',
            'retail_store_received_quantity' => $ret['received_quantity'] ?? [],
            'gift_receives' => $ret['gift_quantity_received'] ?? [],
        ]);
    }
}

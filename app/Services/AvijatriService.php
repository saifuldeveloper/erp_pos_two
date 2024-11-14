<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AvijatriService
{
    protected $secret_key;
    protected $base_url;

    public function __construct()
    {
        $this->secret_key = config('services.avijatri.secret_key');
        $this->base_url = config('services.avijatri.base_url'). '/api/v1';
    }

    public function getAssignedShoes()
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->get($this->base_url . '/get-assigned-shoes');
    }

    public function approveProduct($id, $isApproved)
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->post($this->base_url . '/product-approved', [
            'id' => $id,
            'is_approved' => $isApproved ? 1 : 0,
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

    public function approveInvoice($invoiceId)
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->post($this->base_url . '/invoice-approved', [
            'id' => $invoiceId,
            'retail_store_status' => 'Approved',
        ]);
    }
}

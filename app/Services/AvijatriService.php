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
        $this->base_url = config('services.avijatri.base_url');
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

    public function getInvoices()
    {
        return Http::withHeaders([
            'secret_key' => $this->secret_key,
        ])->get($this->base_url . '/get-invoices');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ErpPosOneController extends Controller
{
    private $secret_key;
    private $base_url;

    public function __construct()
    {
        $this->secret_key = env('RETAIL_SECRET_KEY');
        $this->base_url = env('RETAIL_BASE_URL');
    }

    public function getProducts()
    {
        try {
            $response = Http::withHeaders([
                'secret_key' => $this->secret_key,
            ])->get($this->base_url . '/api/v1/get-assigned-shoes');

            if ($response->status() == 200) {
                $result = $response->json();
                $products = $result['retail_store']['retail_store_shoes'];
                // return response()->json($products);
                return view('backend.erp_pos_one.index', compact('products'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // productApproved
    public function productApproved(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'secret_key' => $this->secret_key,
            ])->post($this->base_url . '/api/v1/product-approved', [
                'id' => $request->id,
                'is_approved' => $request->is_approved == 'true' ? 1 : 0,
            ]);

            if ($response->status() == 200) {
                if ($request->is_approved == 'true') {
                    return response()->json(['status' => 'success', 'message' => 'Product approved successfully']);
                } else {
                    return response()->json(['status' => 'success', 'message' => 'Product disapproved successfully']);
                }
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //getInvoices
    public function getInvoices()
    {
        try {
            $response = Http::withHeaders([
                'secret_key' => $this->secret_key,
            ])->get($this->base_url . '/api/v1/get-invoices');

            if ($response->status() == 200) {
                $result = $response->json();
                $invoices = $result['invoices'];
                return response()->json($invoices);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

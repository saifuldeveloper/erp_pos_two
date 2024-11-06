<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Keygen\Keygen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AvijatriController extends Controller
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
                // return response()->json($invoices);

                foreach ($invoices as $invoice) {
                    foreach ($invoice['invoice_entries'] as $invoice_entry) {
                        $this->productStore($invoice_entry['shoe']);
                    }
                    
                }
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function productStore($shoe)
    {
        $brand_id = Brand::where('title', 'Avijatri')->first()->id;
        $parent_id = null;
        $category_id = null;
        $unit_id = Unit::first()->id;
        if ($shoe['category']['parent']) {
            $existParentCategory = Category::where('name', $shoe['category']['parent']['name'])->first();
            if ($existParentCategory) {
                $parent_id = $existParentCategory->id;
            } else {
                $category = new Category();
                $category->name = $shoe['category']['parent']['name'];
                $category->is_active = 1;
                $category->save();
                $parent_id = $category->id;
            }
        }

        $existCategory = Category::where('name', $shoe['category']['name'])->first();
        if ($existCategory) {
            $category_id = $existCategory->id;
        } else {
            $category = new Category();
            $category->name = $shoe['category']['name'];
            $category->parent_id = $parent_id;
            $category->is_active = 1;
            $category->save();
            $category_id = $category->id;
        }

        $product = new Product();
        $product->name = $shoe['id'];
        $product->code = Keygen::numeric(8)->generate();
        $product->type = null;
        $product->barcode_symbology = null;
        $product->brand_id = $brand_id;
        $product->category_id = $category_id;
        $product->unit_id = $unit_id;
        $product->purchase_unit_id = $unit_id;
        $product->sale_unit_id = $unit_id;
        $product->cost = null;
        $product->price = $shoe['retail_price'];
        $product->qty = null;
        $product->alert_quantity = null;
        $product->promotion = null;
        $product->promotion_price = null;
        $product->starting_date = null;
        $product->last_date = null;
        $product->tax_id = null;
        $product->tax_method = null;
        $product->image = null;
        $product->featured = null;
        $product->product_details = null;
        $product->is_active = 1;
        $product->save();
    }
}

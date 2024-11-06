<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Services\AvijatriService;
use Keygen\Keygen;
use Illuminate\Http\Request;

class AvijatriController extends Controller
{
    protected $avijatriService;

    public function __construct(AvijatriService $avijatriService)
    {
        $this->avijatriService = $avijatriService;
    }

    public function getProducts()
    {
        try {
            $response = $this->avijatriService->getAssignedShoes();

            if ($response->status() == 200) {
                $products = $response->json()['retail_store']['retail_store_shoes'];
                return view('backend.avijatri.index', compact('products'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function productApproved(Request $request)
    {
        try {
            $response = $this->avijatriService->approveProduct($request->id, $request->is_approved == 'true');

            if ($response->status() == 200) {
                $message = $request->is_approved == 'true' ? 'Product approved successfully' : 'Product disapproved successfully';
                return response()->json(['status' => 'success', 'message' => $message]);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getInvoices()
    {
        try {
            $response = $this->avijatriService->getInvoices();

            if ($response->status() == 200) {
                $invoices = $response->json()['invoices'];
                return view('backend.avijatri.invoices', compact('invoices'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getInvoice($id)
    {
        try {
            $response = $this->avijatriService->getInvoice($id);

            if ($response->status() == 200) {
                $invoice = $response->json()['invoice'];
                return response()->json($invoice);
                // return view('backend.avijatri.invoice', compact('invoice'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function invoiceApprove($id)
    {
        try {
            $response = $this->avijatriService->approveInvoice($id);

            if ($response->status() == 200) {
                $invoice = $response->json()['invoice'];
                foreach ($invoice['invoice_entries'] as $entry) {
                    Product::where('code', $entry['shoe']['id'])->first() ?: $this->productStore($entry['shoe']);
                }
                //invoiceStore($invoice);
                return redirect()->route('get-invoices.index');
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
            $parent_id = $this->categoryStore($shoe['category']['parent']);
        }
        $category_id = $this->categoryStore($shoe['category'], $parent_id);

        $product = new Product();
        $product->name = $shoe['id'];
        $product->code = $shoe['id'];
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

    public function categoryStore($shoeCategory, $parent_id = null)
    {
        $existCategory = Category::where('name', $shoeCategory['name'])->first();
        if ($existCategory) {
            return $existCategory->id;
        } else {
            $category = new Category();
            $category->name = $shoeCategory['name'];
            $category->parent_id = $parent_id;
            $category->is_active = 1;
            $category->save();
            return $category->id;
        }
    }

    public function invoiceStore($invoice)
    {
        //
    }
}

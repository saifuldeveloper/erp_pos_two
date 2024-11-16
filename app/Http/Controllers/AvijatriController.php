<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\Purchase;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Services\AvijatriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
                $retailStore = $response->json()['retail_store'];
                $products = $response->json()['retail_store']['retail_store_shoes'];
            } else {
                $retailStore = [];
                $products = [];
            }
            return view('backend.avijatri.index', compact('products', 'retailStore'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function productApproved(Request $request)
    {
        try {
            $response = $this->avijatriService->approveProduct($request);
            if ($response->status() == 200) {
                $message = $request->is_approved == '1' ? 'Product approved successfully' : 'Product disapproved successfully';
                return redirect()->route('get-products')->with('success', $message);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function invoices()
    {
        try {
            $response = $this->avijatriService->invoices();
            if ($response->status() == 200) {
                $invoices = $response->json()['invoices'];
            } else {
                $invoices = 'API error';
            }
            return view('backend.avijatri.invoices', compact('invoices'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function invoice($id)
    {
        try {
            $response = $this->avijatriService->invoice($id);

            if ($response->status() == 200) {
                $invoice = $response->json()['invoice'];
                return view('backend.avijatri.invoice', compact('invoice'));
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
            $response = $this->avijatriService->invoice($id);
            if ($response->status() == 200) {
                $invoice = $response->json()['invoice'];
                foreach ($invoice['invoice_entries'] as $entry) {
                    Product::where('code', $entry['shoe']['id'])->first() ?: $this->productStore($entry['shoe']);
                }
                Purchase::where('reference_no', 'avijatry-' . $id)->first() ?: $this->invoiceStore($invoice);
            } else {
                abort(404);
            }

            $response = $this->avijatriService->approveInvoice($id);
            if ($response->status() == 200) {
                return redirect()->route('invoices.index');
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

        $image_name = null;
        if (isset($shoe['image_url']) && !empty($shoe['image_url'])) {
            $imageUrl = $shoe['image_url'];
            $imageName = basename($imageUrl);
            $imagePath = public_path('public/images/product/' . $imageName);
            if (!File::exists(public_path('public/images/product'))) {
                File::makeDirectory(public_path('images/product'), 0755, true);
            }
            file_put_contents($imagePath, file_get_contents($imageUrl));
            $image_name = $imageName;
        }

        $product = new Product();
        $product->name = $shoe['id'];
        $product->code = $shoe['id'];
        $product->type = 'standard';
        $product->barcode_symbology = 'C128';
        $product->brand_id = $brand_id;
        $product->category_id = $category_id;
        $product->unit_id = $unit_id;
        $product->purchase_unit_id = $unit_id;
        $product->sale_unit_id = $unit_id;
        $product->cost = $shoe['retail_price'];
        $product->price = $shoe['retail_price'];
        $product->qty = null;
        $product->alert_quantity = null;
        $product->promotion = null;
        $product->promotion_price = null;
        $product->starting_date = null;
        $product->last_date = null;
        $product->tax_id = null;
        $product->tax_method = 1;
        $product->image = $image_name;
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
        $purchase = new Purchase();
        $purchase->reference_no = 'avijatry-' . $invoice['id'];
        $purchase->user_id = auth()->user()->id;
        $purchase->warehouse_id = Warehouse::first()->id;
        $purchase->supplier_id = null;
        $purchase->item = count($invoice['invoice_entries']);
        $purchase->total_qty = $invoice['total_pairs'];
        $purchase->total_discount = $invoice['discount'];
        $purchase->total_tax = 0;
        $purchase->total_cost = $invoice['total_amount'];
        $purchase->order_tax_rate = 0;
        $purchase->order_tax = 0;
        $purchase->order_discount = $invoice['discount'];
        $purchase->shipping_cost = $invoice['transport'];
        $purchase->grand_total = $invoice['total_receivable'];
        $purchase->paid_amount = $invoice['total_payment'];
        $purchase->status = 1;
        $purchase->payment_status = 1;
        $purchase->save();

        foreach ($invoice['invoice_entries'] as $entry) {
            $product = Product::where('code', $entry['shoe']['id'])->first();
            $purchase->productPurchases()->create([
                'product_id' => $product->id,
                'qty' => $entry['count'],
                'recieved' => $entry['count'],
                'purchase_unit_id' => $product->unit_id,
                'net_unit_cost' => $product->cost,
                'selling_price' => $product->price,
                'discount' => 0,
                'tax_rate' => 0,
                'tax' => 0,
                'total' => $entry['total_price'],
            ]);
            $product->qty += $entry['count'];
            $product->save();

            $productWarehouse = new Product_Warehouse();
            $productWarehouse->product_id = $product->id;
            $productWarehouse->warehouse_id = Warehouse::first()->id;
            $productWarehouse->qty = $entry['count'];
            $productWarehouse->price = $product->cost;
            $productWarehouse->save();
        }
    }
}

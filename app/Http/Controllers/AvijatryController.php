<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\GiftReceive;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Services\AvijatryService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class AvijatryController extends Controller
{
    protected $avijatryService;

    public function __construct(AvijatryService $avijatryService)
    {
        $this->avijatryService = $avijatryService;
    }

    public function getProducts()
    {
        try {
            $response = $this->avijatryService->getAssignedShoes();
            if ($response->status() == 200) {
                $retailStore = $response->json('retail_store') ?? [];
                $products = $retailStore['retail_store_shoes'] ?? [];
            } else {
                $retailStore = [];
                $products = [];
            }

            return view('backend.avijatry.index', compact('products', 'retailStore'));
        } catch (\Exception $e) {
            $retailStore = [];
            $products = [];
            return view('backend.avijatry.index', compact('products', 'retailStore'))->with('error', 'Unable to connect to Avijatry API: ' . $e->getMessage());
        }
    }

    public function productApproved(Request $request)
    {
        try {
            $response = $this->avijatryService->approveProduct($request);
            if ($response->status() == 200) {
                $message = $request->is_approved == '1' ? 'Product approved successfully' : 'Product disapproved successfully';
                return redirect()->route('get-products')->with('message', $message);
            } else {
                return redirect()->route('get-products')->with('not_permitted', 'Avijatry API error: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->route('get-products')->with('not_permitted', 'Error: ' . $e->getMessage());
        }
    }

    public function invoices(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $response = $this->avijatryService->invoices($page);

            if ($response->successful()) {
                $invoiceData = $response->json('invoices') ?? [];
            } else {
                $invoiceData = 'API error';
            }
            return view('backend.avijatry.invoices', ['invoices' => $invoiceData]);
        } catch (\Exception $e) {
            return view('backend.avijatry.invoices', ['invoices' => 'API error'])->with('error', $e->getMessage());
        }
    }

    public function invoice($id)
    {
        try {
            $purchase = Purchase::with('productPurchases')->where('reference_no', 'avijatry-' . $id)->first();
            $response = $this->avijatryService->invoice($id);

            if ($response->status() == 200) {
                $invoice = $response->json('invoice') ?? [];
                $warehouse = Warehouse::first();
                $shoeCodes = collect($invoice['invoice_entries'] ?? [])->map(function ($e) {
                    return 'A-' . ($e['shoe']['code'] ?? '');
                })->filter()->all();
                $products = Product::with('productVariants')->whereIn('code', $shoeCodes)->get()->keyBy('code');
                $gifts = collect();
                if ($purchase) {
                    $gifts = GiftReceive::where('purchase_id', $purchase->id)->get()->keyBy('gift_transaction_id');
                }
                return view('backend.avijatry.invoice', compact('invoice', 'purchase', 'warehouse', 'products', 'gifts'));
            } else {
                return redirect()->route('invoices.index')->with('not_permitted', 'Invoice not found on Avijatry (Status: ' . $response->status() . ')');
            }
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('not_permitted', 'Error: ' . $e->getMessage());
        }
    }

    protected function downloadShoeImagesConcurrently(array $imagesToDownload)
    {
        $downloadedImages = [];
        if (empty($imagesToDownload)) {
            return $downloadedImages;
        }

        $directory = public_path('images/product');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $pendingDownloads = [];

        foreach ($imagesToDownload as $shoeCode => $imageUrl) {
            if (empty($imageUrl)) {
                continue;
            }
            $imageName = basename(parse_url($imageUrl, PHP_URL_PATH) ?: 'shoe_' . time() . '_' . $shoeCode . '.jpg');
            $filePath = $directory . '/' . $imageName;

            // If already on local disk, use it directly
            if (File::exists($filePath) && filesize($filePath) > 0) {
                $downloadedImages[$shoeCode] = $imageName;
            } else {
                $pendingDownloads[$shoeCode] = [
                    'url' => $imageUrl,
                    'name' => $imageName,
                    'path' => $filePath,
                ];
            }
        }

        if (!empty($pendingDownloads)) {
            // Download in concurrent chunks of 15 to avoid socket saturation
            $chunks = array_chunk($pendingDownloads, 15, true);
            foreach ($chunks as $chunk) {
                try {
                    $responses = Http::pool(function (Pool $pool) use ($chunk) {
                        $poolReqs = [];
                        foreach ($chunk as $shoeCode => $info) {
                            $poolReqs[$shoeCode] = $pool->as($shoeCode)->timeout(10)->connectTimeout(3)->get($info['url']);
                        }
                        return $poolReqs;
                    });

                    foreach ($chunk as $shoeCode => $info) {
                        $res = $responses[$shoeCode] ?? null;
                        if ($res && !($res instanceof \Exception) && $res->successful() && strlen($res->body()) > 0) {
                            @file_put_contents($info['path'], $res->body());
                            $downloadedImages[$shoeCode] = $info['name'];
                        }
                    }
                } catch (\Exception $e) {
                    // Gracefully continue without failing
                }
            }
        }

        return $downloadedImages;
    }

    protected function downloadShoeImage($imageUrl)
    {
        if (empty($imageUrl)) {
            return null;
        }

        try {
            $imageName = basename(parse_url($imageUrl, PHP_URL_PATH) ?: 'shoe_' . time() . '.jpg');
            $directory = public_path('images/product');
            $filePath = $directory . '/' . $imageName;

            if (File::exists($filePath) && filesize($filePath) > 0) {
                return $imageName;
            }

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $response = Http::timeout(5)->connectTimeout(2)->get($imageUrl);
            if ($response->successful() && strlen($response->body()) > 0) {
                file_put_contents($filePath, $response->body());
                return $imageName;
            }
        } catch (\Exception $e) {
            // Silently catch and proceed if image download fails
        }

        return null;
    }

    public function invoiceApprove(Request $request, $id)
    {
        // Support large invoices with many products
        @set_time_limit(300);
        @ini_set('memory_limit', '512M');

        try {
            $response = $this->avijatryService->invoice($id);
            if ($response->status() == 200) {
                $invoice = $response->json('invoice') ?? [];
                if (empty($invoice)) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => 'Invoice data is empty.'], 422);
                    }
                    return redirect()->route('invoices.index')->with('not_permitted', 'Invoice data is empty.');
                }

                // 1. Pre-process and download missing product images in parallel outside DB transaction
                $imagesToDownload = [];
                foreach ($invoice['invoice_entries'] ?? [] as $entry) {
                    $shoe = $entry['shoe'] ?? [];
                    $shoeCode = 'A-' . ($shoe['code'] ?? '');
                    if (!Product::where('code', $shoeCode)->exists() && !empty($shoe['image_url'])) {
                        $imagesToDownload[$shoe['code']] = $shoe['image_url'];
                    }
                }

                $downloadedImages = $this->downloadShoeImagesConcurrently($imagesToDownload);

                // 2. Pure database writes inside atomic transaction
                $ret = DB::transaction(function () use ($invoice, $request, $downloadedImages) {
                    foreach ($invoice['invoice_entries'] ?? [] as $entry) {
                        $shoe = $entry['shoe'] ?? [];
                        $shoeCode = 'A-' . ($shoe['code'] ?? '');
                        if (!Product::where('code', $shoeCode)->first()) {
                            $imageName = $downloadedImages[$shoe['code']] ?? null;
                            $this->productStore($shoe, $invoice['commission'] ?? 0, $imageName);
                        }
                    }
                    return $this->invoiceStore($invoice, $request);
                });
            } else {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => "Avijatry invoice fetch failed. Status: " . $response->status()], 422);
                }
                return redirect()->route('invoices.index')->with('not_permitted', "Avijatry invoice fetch failed. Status: " . $response->status());
            }

            // 3. Remote approval confirmation
            $approveResponse = $this->avijatryService->approveInvoice($id, $ret);
            $isRemoteApproved = $approveResponse->status() == 200;
            $msg = $isRemoteApproved
                ? 'Invoice approved and purchase recorded successfully.'
                : 'Invoice recorded locally, but Avijatry remote confirmation returned status: ' . $approveResponse->status();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'redirect' => route('invoices.index'),
                ]);
            }

            return redirect()->route('invoices.index')->with('message', $msg);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('not_permitted', 'Error: ' . $e->getMessage());
        }
    }

    public function productStore($shoe, $commission = 0, $preloadedImageName = null)
    {
        $brand = Brand::firstOrCreate(['title' => 'Avijatry'], ['is_active' => 1]);
        $brand_id = $brand->id;

        $parent_id = null;
        $category = null;
        $unit = Unit::first();
        $unit_id = $unit ? $unit->id : 1;

        if (!empty($shoe['category'])) {
            if (!empty($shoe['category']['parent'])) {
                $parentCat = $this->categoryStore($shoe['category']['parent'], $parent_id);
                $parent_id = $parentCat ? $parentCat->id : null;
            }
            $category = $this->categoryStore($shoe['category'], $parent_id);
        }

        $color = !empty($shoe['color']) ? $this->colorStore($shoe['color']) : null;

        $image_name = $preloadedImageName;
        if (!$image_name && !empty($shoe['image_url'])) {
            $image_name = $this->downloadShoeImage($shoe['image_url']);
        }

        $variant_value = [];
        $variant_value[0] = $color ? $color->name : 'Standard';
        $size = [];
        if (!empty($shoe['shoe_to_size'])) {
            foreach ($shoe['shoe_to_size'] as $shoeToSize) {
                if (!empty($shoeToSize['size']['name'])) {
                    $size[] = $shoeToSize['size']['name'];
                }
            }
        }
        $size = array_unique($size);
        $variant_value[1] = implode(',', $size);

        $retailPrice = (float)($shoe['retail_price'] ?? 0);
        $cost = $retailPrice - ($retailPrice * (((float)$commission) / 100));

        $product = new Product();
        $product->name = $category ? $category->name : ($shoe['name'] ?? ('Shoe ' . ($shoe['code'] ?? '')));
        $product->code = 'A-' . $shoe['code'];
        $product->type = 'standard';
        $product->barcode_symbology = 'C128';
        $product->brand_id = $brand_id;
        $product->category_id = $category ? $category->id : 1;
        $product->unit_id = $unit_id;
        $product->purchase_unit_id = $unit_id;
        $product->sale_unit_id = $unit_id;
        $product->cost = $cost;
        $product->price = $retailPrice;
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
        $product->variant_option = json_encode(["Color", "Size"]);
        $product->variant_value = json_encode([$variant_value[0], $variant_value[1]]);
        $product->is_active = 1;
        $product->save();

        return $product;
    }

    public function categoryStore($shoeCategory, $parent_id = null)
    {
        $name = is_array($shoeCategory) ? ($shoeCategory['name'] ?? 'General') : (string)$shoeCategory;
        $existCategory = Category::where('name', $name)->first();
        if ($existCategory) {
            return $existCategory;
        } else {
            $category = new Category();
            $category->name = $name;
            $category->parent_id = $parent_id;
            $category->is_active = 1;
            $category->save();
            return $category;
        }
    }

    public function colorStore($shoeColor)
    {
        $name = is_array($shoeColor) ? ($shoeColor['name'] ?? 'Standard') : (string)$shoeColor;
        $existColor = Color::where('name', $name)->first();
        if ($existColor) {
            return $existColor;
        } else {
            $color = new Color();
            $color->name = $name;
            $color->save();
            return $color;
        }
    }

    public function variantStore($shoeToSize, $received_qty, $previous_received_qty, $color, $product)
    {
        $colorName = is_array($color) ? ($color['name'] ?? 'Standard') : (string)$color;
        $sizeName = $shoeToSize['size']['name'] ?? '';
        $variantFullName = $colorName . '/' . $sizeName;

        $variant = Variant::where('name', $variantFullName)->first();
        if (!$variant) {
            $variant = new Variant();
            $variant->name = $variantFullName;
            $variant->save();
        }

        $itemCode = $variantFullName . '-' . $product->code;
        $productVariant = ProductVariant::where('item_code', $itemCode)->first();
        $recQty = (float)($received_qty[$sizeName] ?? 0);

        if ($productVariant) {
            $productVariant->qty = max(0, ($productVariant->qty ?? 0) - (float)$previous_received_qty) + $recQty;
            $productVariant->save();
        } else {
            $productVariant = new ProductVariant();
            $productVariant->product_id = $product->id;
            $productVariant->variant_id = $variant->id;
            $productVariant->position = $product->productVariants->last() ? $product->productVariants->last()->position + 1 : 1;
            $productVariant->item_code = $itemCode;
            $productVariant->qty = $recQty;
            $productVariant->save();
        }

        return $productVariant;
    }

    public function invoiceStore($invoice, $request)
    {
        $warehouse = Warehouse::first();
        $warehouseId = $warehouse ? $warehouse->id : 1;

        $supplier = Supplier::where('name', 'Avijatry')->first();
        if (!$supplier) {
            $supplier = Supplier::create([
                'name' => 'Avijatry',
                'company_name' => 'Avijatry',
                'is_active' => 1
            ]);
        }

        $purchase = Purchase::where('reference_no', 'avijatry-' . $invoice['id'])->first();
        if (!$purchase) {
            $purchase = new Purchase();
        }
        $purchase->reference_no = 'avijatry-' . $invoice['id'];
        $purchase->user_id = auth()->check() ? auth()->user()->id : 1;
        $purchase->warehouse_id = $warehouseId;
        $purchase->supplier_id = $supplier->id;
        $purchase->item = count($invoice['invoice_entries'] ?? []);
        $purchase->total_qty = $invoice['total_pairs'] ?? 0;
        $purchase->total_discount = $invoice['discount'] ?? 0;
        $purchase->total_tax = 0;
        $purchase->total_cost = $request->total_amount ?? ($invoice['total_amount'] ?? 0);
        $purchase->order_tax_rate = 0;
        $purchase->order_tax = 0;
        $purchase->order_discount = $invoice['discount'] ?? 0;
        $purchase->shipping_cost = $invoice['transport'] ?? 0;
        $purchase->grand_total = $request->grand_total ?? ($invoice['total_receivable'] ?? 0);
        $purchase->paid_amount = $request->paid_amount ?? 0;
        $purchase->status = 1;
        $purchase->payment_status = 1;
        $purchase->note = $request->note ?? null;
        $purchase->save();

        $ret_received_qty = [];
        $total_received_qty = 0;

        foreach ($invoice['invoice_entries'] ?? [] as $entry) {
            $shoeCode = $entry['shoe']['code'] ?? '';
            $colorName = $entry['shoe']['color']['name'] ?? 'Standard';
            $product = Product::where('code', ('A-' . $shoeCode))->first();
            if (!$product) {
                continue;
            }

            $receivedQtyArr = $request->received_quantity[$shoeCode] ?? [];
            $sentQtyArr = $request->sent_quantity[$shoeCode] ?? [];

            // A. Update variantStore
            if (!empty($entry['shoe']['shoe_to_size'])) {
                foreach ($entry['shoe']['shoe_to_size'] as $shoeToSize) {
                    if ($shoeToSize['reference_id'] == $invoice['id'] &&
                        strtolower((string)$shoeToSize['shoe_id']) == strtolower((string)$entry['shoe']['id']) &&
                        $shoeToSize['type'] == 'sale') {

                        $itemCode = $colorName . '/' . ($shoeToSize['size']['name'] ?? '') . '-' . $product->code;
                        $productVariant = ProductVariant::where('item_code', $itemCode)->first();

                        $previous_received_qty = 0;
                        if ($productVariant) {
                            $previous_received_qty = (float)$purchase->productPurchases()
                                ->where('product_id', $product->id)
                                ->where('variant_id', $productVariant->variant_id)
                                ->sum('recieved');
                        }

                        $this->variantStore($shoeToSize, $receivedQtyArr, $previous_received_qty, $entry['shoe']['color'] ?? $colorName, $product);
                        $product->is_variant = 1;
                    }
                }
            }

            // B. Adjust previous received quantity on product
            $previous_product_received_qty = (float)$purchase->productPurchases()->where('product_id', $product->id)->sum('recieved');
            if ($previous_product_received_qty > 0) {
                $product->qty = max(0, ($product->qty ?? 0) - $previous_product_received_qty);
                $product->save();
            }

            // C. Update Product_Warehouse
            foreach ($receivedQtyArr as $key => $received_qty) {
                $itemCode = $colorName . '/' . $key . '-' . $product->code;
                $productVariant = ProductVariant::where('item_code', $itemCode)->first();
                if (!$productVariant) {
                    $variantName = $colorName . '/' . $key;
                    $variant = Variant::where('name', $variantName)->first();
                    if (!$variant) {
                        $variant = new Variant();
                        $variant->name = $variantName;
                        $variant->save();
                    }
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product->id;
                    $productVariant->variant_id = $variant->id;
                    $productVariant->position = $product->productVariants->last() ? $product->productVariants->last()->position + 1 : 1;
                    $productVariant->item_code = $itemCode;
                    $productVariant->qty = 0;
                    $productVariant->save();
                }

                $productWarehouse = Product_Warehouse::where('product_id', $product->id)
                    ->where('warehouse_id', $warehouseId)
                    ->where('variant_id', $productVariant->variant_id)
                    ->first();

                $prevPPQty = (float)$purchase->productPurchases()
                    ->where('product_id', $product->id)
                    ->where('variant_id', $productVariant->variant_id)
                    ->sum('recieved');

                if ($productWarehouse) {
                    $productWarehouse->qty = max(0, $productWarehouse->qty - $prevPPQty) + (float)$received_qty;
                    $productWarehouse->price = $product->price;
                    $productWarehouse->save();
                } else {
                    $productWarehouse = new Product_Warehouse();
                    $productWarehouse->product_id = $product->id;
                    $productWarehouse->warehouse_id = $warehouseId;
                    $productWarehouse->variant_id = $productVariant->variant_id;
                    $productWarehouse->qty = (float)$received_qty;
                    $productWarehouse->price = $product->price;
                    $productWarehouse->save();
                }
            }

            // D. Update ProductPurchase records (Sent qty vs Received qty)
            foreach ($sentQtyArr as $key => $sent_qty) {
                $itemCode = $colorName . '/' . $key . '-' . $product->code;
                $productVariant = ProductVariant::where('item_code', $itemCode)->first();
                if (!$productVariant) {
                    $variantName = $colorName . '/' . $key;
                    $variant = Variant::where('name', $variantName)->first();
                    if (!$variant) {
                        $variant = new Variant();
                        $variant->name = $variantName;
                        $variant->save();
                    }
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product->id;
                    $productVariant->variant_id = $variant->id;
                    $productVariant->position = $product->productVariants->last() ? $product->productVariants->last()->position + 1 : 1;
                    $productVariant->item_code = $itemCode;
                    $productVariant->qty = 0;
                    $productVariant->save();
                }

                $recQty = (float)($receivedQtyArr[$key] ?? 0);

                $purchase->productPurchases()->updateOrCreate([
                    'product_id' => $product->id,
                    'variant_id' => $productVariant->variant_id,
                ], [
                    'qty' => (float)$sent_qty,
                    'recieved' => $recQty,
                    'purchase_unit_id' => $product->unit_id,
                    'net_unit_cost' => $product->cost,
                    'selling_price' => $product->price,
                    'discount' => 0,
                    'tax_rate' => 0,
                    'tax' => 0,
                    'total' => $product->cost * $recQty,
                ]);
            }

            // E. Recalculate product overall qty
            $shoe_received_qty = (float)$purchase->productPurchases()->where('product_id', $product->id)->sum('recieved');
            $product->qty = ($product->qty ?? 0) + $shoe_received_qty;
            $product->save();

            $ret_received_qty[$entry['shoe']['id']] = $shoe_received_qty;
            $total_received_qty += $shoe_received_qty;
        }

        // F. Set total_qty across ALL entries
        $purchase->total_qty = $total_received_qty;
        $purchase->save();

        // G. Gift transactions
        if (!empty($invoice['gift_transactions'])) {
            foreach ($invoice['gift_transactions'] as $gift_transaction) {
                $giftReceive = GiftReceive::where('purchase_id', $purchase->id)
                    ->where('gift_transaction_id', $gift_transaction['id'])
                    ->first();
                if (!$giftReceive) {
                    $giftReceive = new GiftReceive();
                }
                $giftReceive->purchase_id = $purchase->id;
                $giftReceive->gift_transaction_id = $gift_transaction['id'];
                $giftReceive->name = $gift_transaction['gift']['name'] ?? 'Gift';
                $giftReceive->quantity = $gift_transaction['count'] ?? 0;
                $giftReceive->quantity_received = $request->gift_quantity_received[$gift_transaction['id']] ?? ($gift_transaction['count'] ?? 0);
                $giftReceive->save();
            }
        }

        $request->merge(['received_quantity' => $ret_received_qty]);
        return $request->all();
    }
}

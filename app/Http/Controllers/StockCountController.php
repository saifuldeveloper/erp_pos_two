<?php

namespace App\Http\Controllers;

use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class StockCountController extends Controller
{
    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('purchases-add')) {
            $stock_count = StockCount::where('is_completed', false)->orWhere('is_resolved', false)->first();
            if ($stock_count) {
                return redirect()->route('stock-count.show', $stock_count->id);
            }
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('backend.stock_count.create', compact('lims_warehouse_list'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function product()
    {
        $stock_count = StockCount::where('is_completed', false)->orWhere('is_resolved', false)->first();

        return Product::ActiveStandard()
            ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
            ->where('product_warehouse.warehouse_id', $stock_count->warehouse_id)
            ->select('products.id', 'products.name', 'products.code')
            ->groupBy('products.id')
            ->get();
    }

    public function productSearch(Request $request)
    {
        $stock_count = StockCount::where('is_completed', false)->orWhere('is_resolved', false)->first();
        $product_code = explode("|", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $product = Product::join('product_warehouse', 'products.id', 'product_warehouse.product_id')
            ->where([
                ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
                ['products.code', $product_code[0]],
                ['products.is_active', true]
            ])
            ->select('products.*')
            ->first();
        if ($product && $product->is_variant) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
                ->where([
                    ['product_variants.product_id', $product->id],
                    ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
                    ['products.is_active', true]
                ])
                ->select('products.*', 'product_variants.item_code', 'product_variants.qty')
                ->groupBy('product_variants.id')
                ->get();
        } else {
            $lims_product_data = Product::join('product_warehouse', 'products.id', 'product_warehouse.product_id')
                ->where([
                    ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
                    ['products.code', $product_code[0]],
                    ['products.is_active', true]
                ])
                ->groupBy('products.id')
                ->get();
        }

        $products = [];
        foreach ($lims_product_data as $key => $product) {
            $products[$key][] = $product->name;
            $products[$key][] = $product->is_variant ? $product->item_code : $product->code;
            $products[$key][] = $product->qty;
            $products[$key][] = $product->id;
        }
        return $products;
    }

    public function store(Request $request)
    {
        $stock_count = new StockCount();
        $stock_count->warehouse_id = $request->warehouse_id;
        $stock_count->save();
        return redirect()->route('stock-count.show', $stock_count->id);
    }

    public function update(Request $request, $id)
    {
        $stock_count = StockCount::findOrFail($id);
        if ($request->status === 'add') {
            foreach ($request['product_code'] as $key => $product_code) {
                if ($request['qty'][$key] == 0 && $request['current_qty'][$key] == 0)
                    continue;
                DB::table('stock_count_items')->insert([
                    'stock_count_id' => $stock_count->id,
                    'product_id' => $request['product_id'][$key],
                    'item_code' => $request['product_code'][$key],
                    'current_quantity' => $request['current_qty'][$key],
                    'updated_quantity' => $request['qty'][$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return back()->with('success', 'Stock count items added successfully.');
        } elseif ($request->status === 'complete') {
            $stock_count->update(['is_completed' => true, 'completed_by' => Auth::id()]);
            return back()->with('success', 'Stock count marked as completed.');

        } elseif ($request->status === 'resolved') {
            DB::beginTransaction();
            try {
                $batch = $request->resolved_batch;
                if ($batch && count($batch) > 0) {
                    // Collect all relevant product IDs and variant IDs (for optimizatio
                    $product_ids = [];
                    $variant_ids = [];
                    foreach ($batch as $data) {
                        $variant = ProductVariant::where('item_code', $data['code'])->first();
                        if ($variant) {
                            $product_ids[] = $variant->product_id;
                            $variant_ids[] = $variant->variant_id;
                        } else {
                            $product = Product::where('code', $data['code'])->first();
                            if ($product)
                                $product_ids[] = $product->id;
                        }
                    }
                    // current warehouse this products stock reset to zero before update
                    Product_Warehouse::whereIn('product_id', array_unique($product_ids))
                        ->where('warehouse_id', $stock_count->warehouse_id)
                        ->update(['qty' => 0]);

                    // then loop through the batch and update the stock count items and product warehouse accordingly
                    foreach ($batch as $data) {
                        $item_code = $data['code'];
                        if ($data['action'] !== 'update_stock')
                            continue;
                        $present_qty = DB::table('stock_count_items')
                            ->where('stock_count_id', $stock_count->id)
                            ->where('item_code', $item_code)
                            ->sum('updated_quantity');

                        $productVariant = ProductVariant::where('item_code', $item_code)->first();

                        if ($productVariant) {
                            // variant product clear and update
                            Product_Warehouse::where('product_id', $productVariant->product_id)
                                ->where('variant_id', $productVariant->variant_id)
                                ->where('warehouse_id', $stock_count->warehouse_id)
                                ->delete();

                            Product_Warehouse::create([
                                'product_id' => $productVariant->product_id,
                                'variant_id' => $productVariant->variant_id,
                                'warehouse_id' => $stock_count->warehouse_id,
                                'qty' => $present_qty
                            ]);

                            // variant product table qty update
                            $productVariant->qty = $present_qty;
                            $productVariant->save();

                            // main product tabble total qty update
                            $mainProduct = Product::find($productVariant->product_id);
                            if ($mainProduct) {
                                $mainProduct->qty = ProductVariant::where('product_id', $mainProduct->id)->sum('qty');
                                $mainProduct->save();
                            }
                        } else {
                            // non-variant product
                            $product = Product::where('code', $item_code)->first();
                            if ($product) {
                                Product_Warehouse::where('product_id', $product->id)
                                    ->where('warehouse_id', $stock_count->warehouse_id)
                                    ->delete();

                                Product_Warehouse::create([
                                    'product_id' => $product->id,
                                    'warehouse_id' => $stock_count->warehouse_id,
                                    'qty' => $present_qty
                                ]);

                                $product->qty = $present_qty;
                                $product->save();
                            }
                        }
                    }
                }

                if ($request->is_final_chunk) {
                    $stock_count->update([
                        'is_resolved' => true,
                        'resolved_by' => Auth::id()
                    ]);
                }
                DB::commit();
                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
        return redirect()->route('stock-count.show', $id);
    }
    public function show($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_stock_count = StockCount::with('items')->find($id);
            $lims_stock_count->items = $lims_stock_count->items->groupBy('item_code');
            if ($lims_stock_count->is_completed == false) {
                $lims_product_list = $this->product();
                return view('backend.stock_count.show_for_complete', compact('lims_stock_count', 'lims_product_list'));
            } elseif ($lims_stock_count->is_resolved == false) {
                return view('backend.stock_count.show_for_resolved', compact('lims_stock_count'));
            } else {
                return redirect('/dashboard');
            }
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}

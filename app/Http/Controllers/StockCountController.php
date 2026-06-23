<?php

namespace App\Http\Controllers;

use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
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

    // public function productSearch(Request $request)
    // {
    //     $stock_count = StockCount::where('is_completed', false)->orWhere('is_resolved', false)->first();
    //     $product_code = explode("|", $request['data']);
    //     $product_code[0] = rtrim($product_code[0], " ");
    //     $product = Product::join('product_warehouse', 'products.id', 'product_warehouse.product_id')
    //         ->where([
    //             ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
    //             ['products.code', $product_code[0]],
    //             ['products.is_active', true]
    //         ])
    //         ->select('products.*')
    //         ->first();
    //     if ($product && $product->is_variant) {
    //         $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
    //             ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
    //             ->where([
    //                 ['product_variants.product_id', $product->id],
    //                 ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
    //                 ['products.is_active', true]
    //             ])
    //             ->select('products.*', 'product_variants.item_code', 'product_variants.qty')
    //             ->groupBy('product_variants.id')
    //             ->get();
    //     } else {
    //         $lims_product_data = Product::join('product_warehouse', 'products.id', 'product_warehouse.product_id')
    //             ->where([
    //                 ['product_warehouse.warehouse_id', $stock_count->warehouse_id],
    //                 ['products.code', $product_code[0]],
    //                 ['products.is_active', true]
    //             ])
    //             ->groupBy('products.id')
    //             ->get();
    //     }

    //     $products = [];
    //     foreach ($lims_product_data as $key => $product) {
    //         $products[$key][] = $product->name;
    //         $products[$key][] = $product->is_variant ? $product->item_code : $product->code;
    //         $products[$key][] = $product->qty;
    //         $products[$key][] = $product->id;
    //     }
    //     return $products;
    // }

    public function productSearch(Request $request)
    {
        $stock_count = StockCount::where('is_completed', false)
            ->orWhere('is_resolved', false)
            ->first();


        $product_code = explode("|", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");


        // Product find
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
                ->select('products.*', 'product_warehouse.qty')
                ->groupBy('products.id')
                ->get();
        }


        $products = [];


        foreach ($lims_product_data as $key => $product) {
            //  Duplicate check
            $exists = StockCountItem::where('stock_count_id', $stock_count->id)
                ->where('product_id', $product->id)
                ->exists();
            $products[$key] = [
                'name' => $product->name,
                'code' => $product->is_variant ? $product->item_code : $product->code,
                'qty' => $product->qty,
                'id' => $product->id,
                'exists' => $exists //  important flag
            ];
        }


        return response()->json($products);
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
                    // ── Step 1: all variants আগে update করো ──
                    $affected_product_ids = [];
                    foreach ($batch as $data) {
                        $item_code = $data['code'];
                        if ($data['action'] === 'cancel') {
                            DB::table('stock_count_items')->where('stock_count_id', $stock_count->id)->where('item_code', $item_code)->delete();
                            continue;
                        }
                        if ($data['action'] !== 'update_stock')
                            continue;

                        $present_qty = DB::table('stock_count_items')->where('stock_count_id', $stock_count->id)->where('item_code', $item_code)->sum('updated_quantity');

                        //  qty কখনো negative হবে না
                        $present_qty = max(0, $present_qty);

                        $productVariant = ProductVariant::where('item_code', $item_code)->first();

                        if ($productVariant) {
                            $productVariant->qty = $present_qty;
                            $productVariant->save();

                            $affected_product_ids[] = $productVariant->product_id;

                        } else {
                            $product = Product::where('code', $item_code)->first();
                            if ($product) {
                                $product->qty = $present_qty;
                                $product->save();
                            }
                        }
                    }

                    // ── Step 2: সব variants update হওয়ার পর
                    //            main product qty recalculate করো ──
                    foreach (array_unique($affected_product_ids) as $product_id) {
                        $mainProduct = Product::find($product_id);
                        if ($mainProduct) {
                            $totalQty = ProductVariant::where('product_id', $product_id)->sum('qty');
                            // product qty ও কখনো negative হবে না
                            $mainProduct->qty = max(0, $totalQty);
                            $mainProduct->save();
                        }
                    }

                    // ── Step 3: affected product_ids বের করো ──
                    $product_ids = [];
                    foreach ($batch as $data) {
                        $variant = ProductVariant::where('item_code', $data['code'])->first();
                        if ($variant) {
                            $product_ids[] = $variant->product_id;
                        } else {
                            $product = Product::where('code', $data['code'])->first();
                            if ($product)
                                $product_ids[] = $product->id;
                        }
                    }
                    $product_ids = array_unique($product_ids);

                    // ── Step 4: warehouse এর সব পুরানো rows DELETE ──
                    Product_Warehouse::whereIn('product_id', $product_ids)->where('warehouse_id', $stock_count->warehouse_id)->delete();

                    // ── Step 5: product_variants থেকে পড়ে warehouse এ fresh insert ──
                    foreach ($product_ids as $product_id) {
                        $allVariants = ProductVariant::where('product_id', $product_id)->get();

                        if ($allVariants->count() > 0) {
                            foreach ($allVariants as $variant) {
                                Product_Warehouse::create([
                                    'product_id' => $variant->product_id,
                                    'variant_id' => $variant->variant_id,
                                    'warehouse_id' => $stock_count->warehouse_id,
                                    'qty' => max(0, $variant->qty),
                                ]);
                            }
                        } else {
                            $product = Product::find($product_id);
                            if ($product) {
                                Product_Warehouse::create([
                                    'product_id' => $product->id,
                                    'warehouse_id' => $stock_count->warehouse_id,
                                    'qty' => max(0, $product->qty),
                                ]);
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

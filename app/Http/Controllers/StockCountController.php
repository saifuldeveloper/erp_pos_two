<?php

namespace App\Http\Controllers;

use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\Warehouse;
use Auth;
use DB;
use Illuminate\Http\Request;
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
                ->groupBy('products.id')
                ->get();
        }

        $products = [];

        foreach ($lims_product_data as $key => $product) {

            // 🔴 Duplicate check
            $exists = StockCountItem::where('stock_count_id', $stock_count->id)
                ->where('product_id', $product->id)
                ->exists();

            $products[$key] = [
                'name' => $product->name,
                'code' => $product->is_variant ? $product->item_code : $product->code,
                'qty' => $product->qty,
                'id' => $product->id,
                'exists' => $exists // 🔥 important flag
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
                if ($request['qty'][$key] == 0 && $request['current_qty'][$key] == 0) {
                    continue;
                }
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
            $stock_count->is_completed = true;
            $stock_count->completed_by = Auth::id();
            $stock_count->save();
            return back()->with('success', 'Stock count marked as completed.');

        } elseif ($request->status === 'resolved') {

            DB::beginTransaction();
            try {
                foreach ($request->resolved as $key => $value) {

                    // 🟢 Skip "all"
                    if ($key === 'all') {
                        continue;
                    }
                    $items = $stock_count->items->where('item_code', $key);
                    if ($items->isEmpty()) {
                        continue;
                    }

                    if ($value === 'update_stock') {
                        $updated_qty = $items->sum('updated_quantity');
                        $total_current_qty = $items->sum('current_quantity');

                        // 🔹 Variant Product
                        $productVariant = ProductVariant::where('item_code', $key)->first();

                        if ($productVariant) {
                            // Update variant quantity
                            $productVariant->qty = $updated_qty;
                            $productVariant->save();

                            // Update warehouse variant record
                            $wareHouseProduct = Product_Warehouse::where('variant_id', $productVariant->variant_id)
                                ->where('warehouse_id', $stock_count->warehouse_id)
                                ->where('product_id', $items->first()->product_id)
                                ->first();
                            if ($wareHouseProduct) {
                                $wareHouseProduct->qty = $updated_qty;
                                $wareHouseProduct->save();
                            }

                            // Update main product stock difference
                            $product = Product::find($productVariant->product_id);
                            if ($product) {
                                $product->qty += ($updated_qty - $total_current_qty);
                                $product->save();
                            }

                        } else {
                            // 🔹 Non-variant product
                            $product = Product::where('code', $items->first()->item_code)->first();

                            if ($product) {
                                $product->qty += ($updated_qty - $total_current_qty);
                                $product->save();

                                // Update warehouse product
                                $wareHouseProduct = Product_Warehouse::where('product_id', $product->id)
                                    ->where('warehouse_id', $stock_count->warehouse_id)
                                    ->first();

                                if ($wareHouseProduct) {
                                    $wareHouseProduct->qty = $updated_qty;
                                    $wareHouseProduct->save();
                                }
                            }
                        }

                    }
                    // else {
                    //     // 🔹 Ignore difference
                    //     foreach ($items as $item) {
                    //         $item->updated_quantity = $item->current_quantity;
                    //         $item->is_resolved = true;
                    //         $item->resolved_at = now();
                    //         $item->save();
                    //     }
                    // }
                }

                // Mark stock count as resolved
                $stock_count->is_resolved = true;
                $stock_count->resolved_by = Auth::id();
                $stock_count->save();

                DB::commit();

                return redirect('/dashboard')->with('success', 'Stock count resolved successfully.');

            } catch (\Exception $e) {
                DB::rollBack();
                // Log::error('Stock resolve failed: ' . $e->getMessage());
                return back()->with('error', 'Failed to resolve stock count.');
            }
        }

        // Default return if nothing matches
        return redirect()->route('stock-count.show', $id);
    }


    // public function update(Request $request, $id)
    // {


    //     $stock_count = StockCount::find($id);
    //     if ($request->status == 'add') {
    //         foreach ($request['product_code'] as $key => $product_code) {
    //             if ($request['qty'][$key] == 0 && $request['current_qty'] == 0) {
    //                 continue;
    //             }
    //             DB::table('stock_count_items')->insert([
    //                 'stock_count_id' => $stock_count->id,
    //                 'product_id' => $request['product_id'][$key],
    //                 'item_code' => $request['product_code'][$key],
    //                 'current_quantity' => $request['current_qty'][$key],
    //                 'updated_quantity' => $request['qty'][$key],
    //                 'created_at' => now(),
    //                 'updated_at' => now()
    //             ]);
    //         }
    //     } elseif ($request->status == 'complete') {
    //         $stock_count->is_completed = true;
    //         $stock_count->completed_by = Auth::user()->id;
    //         $stock_count->save();
    //     } elseif ($request->status == 'resolved') {
    //         foreach ($request->resolved as $key => $value) {
    //             if ($key === 'all') {
    //                 continue;
    //             }

    //             $items = $stock_count->items->where('item_code', $key);
    //             if ($items->isEmpty()) {
    //                 continue;
    //             }

    //             if ($value === 'update_stock') {
    //                 $updated_qty = $items->sum('updated_quantity');
    //                 $total_current_qty = $items->sum('current_quantity');

    //                 $productVariant = ProductVariant::where('item_code', $key)->first();

    //                 if ($productVariant) {
    //                     $productVariant->qty = $updated_qty;
    //                     $productVariant->save();
    //                     $wareHouseProduct = Product_Warehouse::where('variant_id', $productVariant->variant_id)
    //                         ->where('warehouse_id', $stock_count->warehouse_id)
    //                         ->where('product_id', $items->first()->product_id)
    //                         ->first();

    //                     if ($wareHouseProduct) {
    //                         $wareHouseProduct->qty = $updated_qty;
    //                         $wareHouseProduct->save();
    //                     }

    //                     // Update main product stock difference
    //                     $product = Product::find($productVariant->product_id);
    //                     if ($product) {
    //                         $product->qty += ($updated_qty - $total_current_qty);
    //                         $product->save();
    //                     }

    //                 } else {
    //                     dd('not_varient');

    //                     // not Varient product
    //                     $product = Product::where('code', $items[0]->item_code)->first();
    //                     if ($product) {
    //                         $product->qty += ($updated_qty - $total_current_qty);
    //                         $product->save();
    //                     }
    //                     $wareHouseProduct = Product_Warehouse::where('product_id', $product->id ?? null)
    //                         ->where('warehouse_id', $stock_count->warehouse_id)
    //                         ->first();

    //                     if ($wareHouseProduct) {
    //                         $wareHouseProduct->qty = $updated_qty;
    //                         $wareHouseProduct->save();
    //                     }

    //                 }
    //                 foreach ($items as $item) {
    //                     $item->is_resolved = true;
    //                     $item->resolved_at = now();
    //                     $item->save();
    //                 }
    //             } else {
    //                 $items = $stock_count->items->where('item_code', $key)->all();
    //                 foreach ($items as $item) {
    //                     $item->updated_quantity = $item->current_quantity;
    //                     $item->save();
    //                 }


    //             }
    //         }
    //         $stock_count->is_resolved = true;
    //         $stock_count->resolved_by = Auth::user()->id;
    //         $stock_count->save();

    //         return redirect('/dashboard');
    //     }

    //     return redirect()->route('stock-count.show', $id);
    // }

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

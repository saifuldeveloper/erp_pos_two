<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product_Sale;
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
                // Clean up duplicate rows in product_warehouse for this warehouse at the beginning of resolution
                $chunk_index = $request->input('chunk_index', 0);
                if ($chunk_index == 0) {
                    $duplicates = DB::table('product_warehouse')
                        ->select('product_id', 'variant_id', DB::raw('MIN(id) as keep_id'))
                        ->where('warehouse_id', $stock_count->warehouse_id)
                        ->groupBy('product_id', 'variant_id')
                        ->havingRaw('COUNT(*) > 1')
                        ->get();

                    foreach ($duplicates as $dup) {
                        $query = Product_Warehouse::where('warehouse_id', $stock_count->warehouse_id)
                            ->where('product_id', $dup->product_id)
                            ->where('id', '!=', $dup->keep_id);
                        if (is_null($dup->variant_id)) {
                            $query->whereNull('variant_id');
                        } else {
                            $query->where('variant_id', $dup->variant_id);
                        }
                        $query->delete();
                    }
                }

                $batch = $request->resolved_batch;

                if ($batch && count($batch) > 0) {
                    foreach ($batch as $data) {
                        $item_code = $data['code'];
                        if ($data['action'] === 'cancel') {
                            DB::table('stock_count_items')->where('stock_count_id', $stock_count->id)->where('item_code', $item_code)->delete();
                            continue;
                        }
                        if ($data['action'] !== 'update_stock')
                            continue;

                        // Get the counted item details
                        $stock_count_items = DB::table('stock_count_items')
                            ->where('stock_count_id', $stock_count->id)
                            ->where('item_code', $item_code)
                            ->get();

                        if ($stock_count_items->isEmpty())
                            continue;

                        $first_item = $stock_count_items->first();
                        $counted_qty = $stock_count_items->sum('updated_quantity');
                        $saved_qty = $first_item->current_quantity;

                        // Find product and variant using item_code (to handle shifted product IDs from database imports)
                        $productVariant = ProductVariant::where('item_code', $item_code)->first();
                        $product = null;
                        $variant_id = null;

                        if ($productVariant) {
                            $variant_id = $productVariant->variant_id;
                            $product = Product::find($productVariant->product_id);
                        } else {
                            $product = Product::where('code', $item_code)->first();
                            if (!$product) {
                                $product = Product::find($first_item->product_id);
                                if ($product) {
                                    $productVariant = ProductVariant::join('variants', 'product_variants.variant_id', '=', 'variants.id')
                                        ->where('variants.name', $item_code)
                                        ->where('product_variants.product_id', $product->id)
                                        ->select('product_variants.*')
                                        ->first();
                                    if ($productVariant) {
                                        $variant_id = $productVariant->variant_id;
                                    }
                                }
                            }
                        }

                        if (!$product)
                            continue;

                        // Calculate sales of this product/variant in this warehouse after it was counted
                        $last_counted_at = $stock_count_items->max('created_at');
                        
                        $sale_query = DB::table('product_sales')
                            ->join('sales', 'product_sales.sale_id', '=', 'sales.id')
                            ->where('sales.warehouse_id', $stock_count->warehouse_id)
                            ->where('product_sales.product_id', $first_item->product_id);

                        if ($variant_id) {
                            $sale_query->where('product_sales.variant_id', $variant_id);
                        }

                        $sold_after_count = (int) $sale_query->where('sales.created_at', '>=', $last_counted_at)
                            ->sum('product_sales.qty');

                        // Calculate wastes of this product/variant after it was counted (Note: waste does not have warehouse_id)
                        $waste_query = DB::table('waste_items')
                            ->join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
                            ->where('waste_items.product_id', $first_item->product_id);

                        if ($variant_id) {
                            $waste_query->where('waste_items.varient_code', $item_code);
                        } else {
                            $waste_query->where(function($q) {
                                $q->whereNull('waste_items.varient_code')
                                  ->orWhere('waste_items.varient_code', '');
                            });
                        }

                        $sold_waste_qty = (int) $waste_query->where('wastes.created_at', '>=', $last_counted_at)
                            ->sum('waste_items.qty');

                        $new_qty = max(0, $counted_qty - $sold_after_count - $sold_waste_qty);

                        // 1. Update Product_Warehouse record
                        if ($variant_id) {
                            $warehouse_product = Product_Warehouse::FindProductWithVariant($product->id, $variant_id, $stock_count->warehouse_id)->first();
                        } else {
                            $warehouse_product = Product_Warehouse::FindProductWithoutVariant($product->id, $stock_count->warehouse_id)->first();
                        }

                        if ($warehouse_product) {
                            $warehouse_product->qty = $new_qty;
                            $warehouse_product->save();
                        } else {
                            // If it didn't exist in this warehouse, create it
                            $warehouse_product = new Product_Warehouse();
                            $warehouse_product->product_id = $product->id;
                            $warehouse_product->variant_id = $variant_id;
                            $warehouse_product->warehouse_id = $stock_count->warehouse_id;
                            $warehouse_product->qty = $new_qty;
                            $warehouse_product->save();
                        }

                        // 2. Update Global stock by summing warehouse stocks to prevent out-of-sync capping issues
                        if ($productVariant) {
                            $total_variant_warehouse_qty = Product_Warehouse::where('product_id', $product->id)
                                ->where('variant_id', $variant_id)
                                ->sum('qty');
                            $productVariant->qty = max(0, $total_variant_warehouse_qty);
                            $productVariant->save();

                            // Recalculate main product's global stock (sum of all its variants' global stocks)
                            $total_variant_qty = ProductVariant::where('product_id', $product->id)->sum('qty');
                            $product->qty = max(0, $total_variant_qty);
                            $product->save();
                        } else {
                            $total_product_warehouse_qty = Product_Warehouse::where('product_id', $product->id)->sum('qty');
                            $product->qty = max(0, $total_product_warehouse_qty);
                            $product->save();
                        }
                    }
                }

                if ($request->is_final_chunk) {
                    if ($request->zero_remaining == 1) {
                        // 1. Get all counted item codes and resolve their current product IDs using item_code
                        $counted_items = DB::table('stock_count_items')
                            ->where('stock_count_id', $stock_count->id)
                            ->select('product_id', 'item_code')
                            ->get();

                        $counted_item_codes = $counted_items->pluck('item_code')->unique()->toArray();
                        
                        $counted_product_ids = [];
                        foreach ($counted_item_codes as $item_code) {
                            $productVariant = ProductVariant::where('item_code', $item_code)->first();
                            if ($productVariant) {
                                $counted_product_ids[] = $productVariant->product_id;
                            } else {
                                $product = Product::where('code', $item_code)->first();
                                if ($product) {
                                    $counted_product_ids[] = $product->id;
                                } else {
                                    // Fallback to stock_count_items' original product_id if not found
                                    $first_match = $counted_items->where('item_code', $item_code)->first();
                                    if ($first_match) {
                                        $counted_product_ids[] = $first_match->product_id;
                                    }
                                }
                            }
                        }
                        $counted_product_ids = array_unique($counted_product_ids);

                        // 2. Find all product_warehouse entries in this warehouse that have qty > 0
                        $remaining_warehouse_products = Product_Warehouse::where('warehouse_id', $stock_count->warehouse_id)
                            ->where('qty', '>', 0)
                            ->get();

                        foreach ($remaining_warehouse_products as $wp) {
                            $was_counted = false;
                            
                            if ($wp->variant_id) {
                                $pv = ProductVariant::where('product_id', $wp->product_id)
                                    ->where('variant_id', $wp->variant_id)
                                    ->first();
                                if ($pv) {
                                    $v = DB::table('variants')->where('id', $pv->variant_id)->first();
                                    if (in_array($pv->item_code, $counted_item_codes) || ($v && in_array($v->name, $counted_item_codes))) {
                                        $was_counted = true;
                                    }
                                }
                            } else {
                                if (in_array($wp->product_id, $counted_product_ids)) {
                                    $was_counted = true;
                                }
                            }

                            if (!$was_counted) {
                                // Zero out this warehouse product qty
                                $wp->qty = 0;
                                $wp->save();

                                // Update global stocks
                                if ($wp->variant_id) {
                                    // Recalculate variant global stock
                                    $variant = ProductVariant::where('variant_id', $wp->variant_id)
                                        ->where('product_id', $wp->product_id)
                                        ->first();
                                    if ($variant) {
                                        $total_variant_qty = Product_Warehouse::where('product_id', $wp->product_id)
                                            ->where('variant_id', $wp->variant_id)
                                            ->sum('qty');
                                        $variant->qty = max(0, $total_variant_qty);
                                        $variant->save();
                                    }

                                    // Recalculate parent product global stock
                                    $parent_product = Product::find($wp->product_id);
                                    if ($parent_product) {
                                        $total_variant_qty = ProductVariant::where('product_id', $parent_product->id)->sum('qty');
                                        $parent_product->qty = max(0, $total_variant_qty);
                                        $parent_product->save();
                                    }
                                } else {
                                    // Recalculate product global stock
                                    $parent_product = Product::find($wp->product_id);
                                    if ($parent_product) {
                                        $total_product_qty = Product_Warehouse::where('product_id', $wp->product_id)->sum('qty');
                                        $parent_product->qty = max(0, $total_product_qty);
                                        $parent_product->save();
                                    }
                                }
                            }
                        }
                    }

                    $stock_count->update([
                        'is_resolved' => true,
                        'resolved_by' => Auth::id()
                    ]);
                }

                DB::commit();
                return response()->json(['status' => 'success']);

            } catch (\Throwable $e) {
                DB::rollBack();
                \Log::error('StockCountController resolve error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
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

    public function remainingProducts($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_stock_count = StockCount::with('items')->findOrFail($id);
            $counted_product_ids = $lims_stock_count->items->pluck('product_id')->unique()->toArray();

            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = Category::with('parent')->where('is_active', true)->get();

            $brand_id = request()->input('brand_id', 0);
            $category_id = request()->input('category_id', 0);
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $query = Product::ActiveStandard()
                ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
                ->where('product_warehouse.warehouse_id', $lims_stock_count->warehouse_id)
                ->where('product_warehouse.qty', '>', 0);

            if ($brand_id != 0) {
                $query->where('products.brand_id', $brand_id);
            }
            if ($category_id != 0) {
                $query->where('products.category_id', $category_id);
            }
            if ($start_date) {
                $query->whereDate('products.created_at', '>=', date('Y-m-d', strtotime($start_date)));
            }
            if ($end_date) {
                $query->whereDate('products.created_at', '<=', date('Y-m-d', strtotime($end_date)));
            }

            $remainingProducts = $query->select('products.id', 'products.name', 'products.code', 'products.price', 'products.cost', 'product_warehouse.qty')
                ->groupBy('products.id')
                ->get()
                ->filter(function($p) use ($counted_product_ids) {
                    return !in_array($p->id, $counted_product_ids);
                });

            $remainingCount = $remainingProducts->count();
            $remainingQty = $remainingProducts->sum('qty');
            $totalRemainingPurchaseValue = $remainingProducts->sum(function($p) {
                return $p->qty * $p->cost;
            });
            $totalRemainingSaleValue = $remainingProducts->sum(function($p) {
                return $p->qty * $p->price;
            });

            return view('backend.stock_count.remaining_products', compact(
                'lims_stock_count',
                'remainingProducts',
                'remainingCount',
                'remainingQty',
                'totalRemainingPurchaseValue',
                'totalRemainingSaleValue',
                'lims_brand_list',
                'lims_category_list',
                'brand_id',
                'category_id',
                'start_date',
                'end_date'
            ));
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    public function soldProducts($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_stock_count = StockCount::with('warehouse')->findOrFail($id);

            $counted_item_codes = DB::table('stock_count_items')
                ->where('stock_count_id', $lims_stock_count->id)
                ->pluck('item_code')
                ->unique()
                ->toArray();

            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = Category::with('parent')->where('is_active', true)->get();

            $brand_id = request()->input('brand_id', 0);
            $category_id = request()->input('category_id', 0);
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $countedItemsSubquery = DB::table('stock_count_items')
                ->select('item_code', 'product_id', DB::raw('MAX(created_at) as last_counted_at'))
                ->where('stock_count_id', $lims_stock_count->id)
                ->groupBy('item_code', 'product_id');

            $query = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
                ->join('products', 'product_sales.product_id', '=', 'products.id')
                ->leftJoin('product_variants', function($join) {
                    $join->on('product_sales.product_id', '=', 'product_variants.product_id')
                         ->on('product_sales.variant_id', '=', 'product_variants.variant_id');
                })
                ->joinSub($countedItemsSubquery, 'sci', function($join) {
                    $join->on('product_sales.product_id', '=', 'sci.product_id')
                         ->whereRaw('(product_variants.item_code = sci.item_code OR (product_sales.variant_id IS NULL AND products.code = sci.item_code))');
                })
                ->where('sales.warehouse_id', $lims_stock_count->warehouse_id)
                ->where('sales.created_at', '>=', $lims_stock_count->created_at)
                ->whereColumn('sales.created_at', '>=', 'sci.last_counted_at');

            if ($lims_stock_count->is_completed) {
                $query->where('sales.created_at', '<=', $lims_stock_count->updated_at);
            }

            if ($brand_id != 0) {
                $query->where('products.brand_id', $brand_id);
            }
            if ($category_id != 0) {
                $query->where('products.category_id', $category_id);
            }
            if ($start_date) {
                $query->whereDate('sales.created_at', '>=', date('Y-m-d', strtotime($start_date)));
            }
            if ($end_date) {
                $query->whereDate('sales.created_at', '<=', date('Y-m-d', strtotime($end_date)));
            }

            $soldProducts = $query->select(
                    'products.id',
                    'products.name',
                    DB::raw('COALESCE(product_variants.item_code, products.code) as code'),
                    'products.price',
                    'products.cost',
                    DB::raw('SUM(product_sales.qty) as sold_qty')
                )
                ->groupBy('products.id', 'products.name', 'product_variants.item_code', 'products.code', 'products.price', 'products.cost')
                ->get();

            $soldCount = $soldProducts->count();
            $soldQty = $soldProducts->sum('sold_qty');
            $totalSoldPurchaseValue = $soldProducts->sum(function($p) {
                return $p->sold_qty * $p->cost;
            });
            $totalSoldSaleValue = $soldProducts->sum(function($p) {
                return $p->sold_qty * $p->price;
            });

            return view('backend.stock_count.sold_products', compact(
                'lims_stock_count',
                'soldProducts',
                'soldCount',
                'soldQty',
                'totalSoldPurchaseValue',
                'totalSoldSaleValue',
                'lims_brand_list',
                'lims_category_list',
                'brand_id',
                'category_id',
                'start_date',
                'end_date'
            ));
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    public function wasteProducts($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_stock_count = StockCount::with('warehouse')->findOrFail($id);

            $counted_item_codes = DB::table('stock_count_items')
                ->where('stock_count_id', $lims_stock_count->id)
                ->pluck('item_code')
                ->unique()
                ->toArray();

            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = Category::with('parent')->where('is_active', true)->get();

            $brand_id = request()->input('brand_id', 0);
            $category_id = request()->input('category_id', 0);
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $countedItemsSubquery = DB::table('stock_count_items')
                ->select('product_id', DB::raw('MAX(created_at) as last_counted_at'))
                ->where('stock_count_id', $lims_stock_count->id)
                ->groupBy('product_id');

            $query = \App\Models\WasteItem::join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
                ->join('products', 'waste_items.product_id', '=', 'products.id')
                ->joinSub($countedItemsSubquery, 'sci', function($join) {
                    $join->on('waste_items.product_id', '=', 'sci.product_id');
                })
                ->where('wastes.created_at', '>=', $lims_stock_count->created_at)
                ->whereColumn('wastes.created_at', '>=', 'sci.last_counted_at');

            if ($lims_stock_count->is_completed) {
                $query->where('wastes.created_at', '<=', $lims_stock_count->updated_at);
            }

            if ($brand_id != 0) {
                $query->where('products.brand_id', $brand_id);
            }
            if ($category_id != 0) {
                $query->where('products.category_id', $category_id);
            }
            if ($start_date) {
                $query->whereDate('wastes.created_at', '>=', date('Y-m-d', strtotime($start_date)));
            }
            if ($end_date) {
                $query->whereDate('wastes.created_at', '<=', date('Y-m-d', strtotime($end_date)));
            }

            $wasteProducts = $query->select(
                    'products.id',
                    'products.name',
                    'products.code as code',
                    'products.price',
                    'products.cost',
                    DB::raw('SUM(waste_items.qty) as waste_qty')
                )
                ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'products.cost')
                ->get();

            $wasteCount = $wasteProducts->count();
            $wasteQty = $wasteProducts->sum('waste_qty');
            $totalWastePurchaseValue = $wasteProducts->sum(function($p) {
                return $p->waste_qty * $p->cost;
            });
            $totalWasteSaleValue = $wasteProducts->sum(function($p) {
                return $p->waste_qty * $p->price;
            });

            return view('backend.stock_count.waste_products', compact(
                'lims_stock_count',
                'wasteProducts',
                'wasteCount',
                'wasteQty',
                'totalWastePurchaseValue',
                'totalWasteSaleValue',
                'lims_brand_list',
                'lims_category_list',
                'brand_id',
                'category_id',
                'start_date',
                'end_date'
            ));
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    public function markAsIncomplete($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $stock_count = StockCount::findOrFail($id);
            if ($stock_count->is_completed && !$stock_count->is_resolved) {
                $stock_count->update([
                    'is_completed' => false,
                    'completed_by' => null
                ]);
                return redirect()->route('stock-count.show', $id)->with('success', 'Stock count reverted to incomplete state successfully.');
            }
            return redirect()->back()->with('error', 'Cannot revert this stock count.');
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }
}

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
use App\Models\WasteItem;
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
        $stock_count_id = $request->input('stock_count_id');
        if ($stock_count_id) {
            $stock_count = StockCount::find($stock_count_id);
        } else {
            $stock_count = StockCount::where('is_completed', false)
                ->orWhere('is_resolved', false)
                ->first();
        }

        if (!$stock_count) {
            return response()->json([]);
        }

        $product_code = explode("|", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        // First try to find by main product code
        $product = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        // If not found, try to find by variant item code
        if (!$product) {
            $variant = ProductVariant::where('item_code', $product_code[0])->first();
            if ($variant) {
                $product = Product::where([
                    ['id', $variant->product_id],
                    ['is_active', true]
                ])->first();
            }
        }

        if ($product && $product->is_variant) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->leftJoin('product_warehouse', function ($join) use ($stock_count) {
                    $join->on('product_variants.product_id', '=', 'product_warehouse.product_id')
                         ->on('product_variants.variant_id', '=', 'product_warehouse.variant_id')
                         ->where('product_warehouse.warehouse_id', $stock_count->warehouse_id);
                })
                ->where([
                    ['product_variants.product_id', $product->id],
                    ['products.is_active', true]
                ])
                ->select(
                    'products.id',
                    'products.name',
                    'products.code',
                    'products.is_variant',
                    'product_variants.item_code',
                    DB::raw('COALESCE(product_warehouse.qty, 0) as qty')
                )
                ->groupBy('product_variants.id')
                ->get();
        } elseif ($product) {
            $lims_product_data = Product::leftJoin('product_warehouse', function ($join) use ($stock_count) {
                    $join->on('products.id', '=', 'product_warehouse.product_id')
                         ->where('product_warehouse.warehouse_id', $stock_count->warehouse_id);
                })
                ->where([
                    ['products.id', $product->id],
                    ['products.is_active', true]
                ])
                ->select(
                    'products.id',
                    'products.name',
                    'products.code',
                    'products.is_variant',
                    DB::raw('COALESCE(product_warehouse.qty, 0) as qty')
                )
                ->groupBy('products.id')
                ->get();
        } else {
            $lims_product_data = [];
        }

        $products = [];

        foreach ($lims_product_data as $key => $item) {
            $itemCode = $item->is_variant ? $item->item_code : $item->code;
            
            // Duplicate check by item_code
            $exists = StockCountItem::where('stock_count_id', $stock_count->id)
                ->where('item_code', $itemCode)
                ->exists();

            $products[$key] = [
                'name' => $item->name,
                'code' => $itemCode,
                'qty' => $item->qty,
                'id' => $item->id,
                'exists' => $exists
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
                $chunk_index = $request->input('chunk_index', 0);
                if ($chunk_index == 0) {
                    $this->syncStockCountItemsProductIds($stock_count);
                    $this->cleanDuplicateWarehousesAndVariants($stock_count);
                    if ($request->deduct_sold == 1) {
                        $this->deductSoldProductsStock($stock_count);
                    }
                    if ($request->deduct_waste == 1) {
                        $this->deductWasteProductsStock($stock_count);
                    }
                }
                $batch = $request->resolved_batch;
                if ($batch && count($batch) > 0) {
                    $this->processBatchUpdates($stock_count, $batch);
                }
                if ($request->is_final_chunk) {
                    if ($request->zero_remaining == 1) {
                        $this->zeroRemainingProductsStock($stock_count);
                    }
                    // Recalculate global stock ONCE on the final chunk
                    $this->recalculateGlobalStocks();

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
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        if (empty($term)) {
            return response()->json([]);
        }

        $stock_count = StockCount::where('is_completed', false)
            ->orWhere('is_resolved', false)
            ->first();

        if (!$stock_count) {
            return response()->json([]);
        }

        // First, check if there is an exact match on products.code
        $exactProduct = Product::ActiveStandard()
            ->where('code', $term)
            ->select('code', 'name')
            ->first();
            
        if ($exactProduct) {
            $results = [htmlspecialchars($exactProduct->code) . '|' . preg_replace('/[\n\r]/', '<br>', htmlspecialchars($exactProduct->name))];
            return response()->json($results);
        }

        // Second, check if there is an exact match on product_variants.item_code
        $exactVariant = ProductVariant::join('products', 'products.id', '=', 'product_variants.product_id')
            ->where('product_variants.item_code', $term)
            ->where('products.is_active', true)
            ->select('product_variants.item_code as code', 'products.name')
            ->first();

        if ($exactVariant) {
            $results = [htmlspecialchars($exactVariant->code) . '|' . preg_replace('/[\n\r]/', '<br>', htmlspecialchars($exactVariant->name))];
            return response()->json($results);
        }

        $products = Product::ActiveStandard()
            ->where(function($query) use ($term) {
                $query->where('products.name', 'LIKE', '%' . $term . '%')
                      ->orWhere('products.code', 'LIKE', '%' . $term . '%');
            })
            ->select('products.code', 'products.name')
            ->distinct()
            ->limit(20)
            ->get();

        if ($products->count() < 20) {
            $variantProducts = Product::ActiveStandard()
                ->join('product_variants', 'products.id', 'product_variants.product_id')
                ->where('product_variants.item_code', 'LIKE', '%' . $term . '%')
                ->select('product_variants.item_code as code', 'products.name')
                ->distinct()
                ->limit(20 - $products->count())
                ->get();
            
            $products = $products->concat($variantProducts);
        }

        $results = [];
        foreach ($products as $product) {
            $results[] = htmlspecialchars($product->code) . '|' . preg_replace('/[\n\r]/', '<br>', htmlspecialchars($product->name));
        }

        return response()->json($results);
    }

    public function show($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_stock_count = StockCount::with(['items.product'])->find($id);
            if (!$lims_stock_count) {
                abort(404);
            }
            
            $itemsGrouped = collect($lims_stock_count->items)->groupBy('item_code');
            $lims_stock_count->setRelation('items', $itemsGrouped);

            // 1. Calculate Stock Matched, Over Stock, Under Stock
            $stockMatched = $itemsGrouped->filter(function ($items) {
                $total = $items->sum('updated_quantity');
                return $total == $items[0]->current_quantity;
            });

            $overStock = $itemsGrouped->filter(function ($items) {
                $total = $items->sum('updated_quantity');
                return $total > $items[0]->current_quantity;
            });

            $underStock = $itemsGrouped->filter(function ($items) {
                $total = $items->sum('updated_quantity');
                return $total < $items[0]->current_quantity;
            });

            // 2. Statistics sums
            $matchedCountQty = 0;
            foreach ($stockMatched as $items) {
                $matchedCountQty += $items->sum('updated_quantity');
            }

            $overCountQty = 0;
            $overFindQty = 0;
            foreach ($overStock as $items) {
                $overCountQty += $items->sum('updated_quantity') - $items[0]->current_quantity;
                $overFindQty += $items->sum('updated_quantity');
            }

            $underCountQty = 0;
            $underFindQty = 0;
            foreach ($underStock as $items) {
                $underCountQty += $items[0]->current_quantity - $items->sum('updated_quantity');
                $underFindQty += $items->sum('updated_quantity');
            }

            $totalCountedQty = $lims_stock_count->items->flatten()->sum('updated_quantity');
            $totalCountedProducts = count($lims_stock_count->items);

            // 3. Counted product IDs
            $counted_product_ids = $lims_stock_count->items->flatten()->pluck('product_id')->unique()->toArray();

            // 4. Remaining Products Count & Qty
            $remainingQuery = DB::table('product_warehouse')
                ->join('products', 'products.id', '=', 'product_warehouse.product_id')
                ->where('product_warehouse.warehouse_id', $lims_stock_count->warehouse_id)
                ->where('product_warehouse.qty', '>', 0)
                ->where('products.is_active', true)
                ->where('products.type', 'standard')
                ->whereNotIn('products.id', $counted_product_ids);

            $remainingCount = $remainingQuery->count('products.id');
            $remainingQty = $remainingQuery->sum('product_warehouse.qty');

            // 5. Sold Products Count & Qty
            $countedItemsSubquery = DB::table('stock_count_items')
                ->select('item_code', 'product_id', DB::raw('MAX(created_at) as last_counted_at'))
                ->where('stock_count_id', $lims_stock_count->id)
                ->groupBy('item_code', 'product_id');

            $soldQuery = DB::table('product_sales')
                ->join('sales', 'product_sales.sale_id', '=', 'sales.id')
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
                $soldQuery->where('sales.created_at', '<=', $lims_stock_count->updated_at);
            }

            $soldData = $soldQuery->select(
                DB::raw('COUNT(DISTINCT COALESCE(product_variants.item_code, products.code)) as sold_count'),
                DB::raw('SUM(product_sales.qty) as sold_qty')
            )->first();

            $soldCount = $soldData->sold_count ?? 0;
            $soldQty = $soldData->sold_qty ?? 0;

            // 6. Waste Products Count & Qty
            $wasteItemsSubquery = DB::table('stock_count_items')
                ->select('product_id', DB::raw('MAX(created_at) as last_counted_at'))
                ->where('stock_count_id', $lims_stock_count->id)
                ->groupBy('product_id');

            $wasteQuery = DB::table('waste_items')
                ->join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
                ->join('products', 'waste_items.product_id', '=', 'products.id')
                ->joinSub($wasteItemsSubquery, 'sci', function($join) {
                    $join->on('waste_items.product_id', '=', 'sci.product_id');
                })
                ->where('wastes.created_at', '>=', $lims_stock_count->created_at)
                ->whereColumn('wastes.created_at', '>=', 'sci.last_counted_at');

            if ($lims_stock_count->is_completed) {
                $wasteQuery->where('wastes.created_at', '<=', $lims_stock_count->updated_at);
            }

            $wasteData = $wasteQuery->select(
                DB::raw('COUNT(DISTINCT products.code) as waste_count'),
                DB::raw('SUM(waste_items.qty) as waste_qty')
            )->first();

            $wasteCount = $wasteData->waste_count ?? 0;
            $wasteQty = $wasteData->waste_qty ?? 0;

            $compactData = compact(
                'lims_stock_count',
                'stockMatched',
                'overStock',
                'underStock',
                'matchedCountQty',
                'overCountQty',
                'overFindQty',
                'underCountQty',
                'underFindQty',
                'totalCountedQty',
                'totalCountedProducts',
                'remainingCount',
                'remainingQty',
                'soldCount',
                'soldQty',
                'wasteCount',
                'wasteQty'
            );

            if ($lims_stock_count->is_completed == false) {
                return view('backend.stock_count.show_for_complete', $compactData);
            } elseif ($lims_stock_count->is_resolved == false) {
                return view('backend.stock_count.show_for_resolved', $compactData);
            } else {
                return redirect('/dashboard');
            }
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
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

            $query->whereNotIn('products.id', $counted_product_ids);

            $remainingProducts = $query->select('products.id', 'products.name', 'products.code', 'products.price', 'products.cost', 'product_warehouse.qty')
                ->groupBy('products.id')
                ->get();

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

            $query =WasteItem::join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
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

    /**
     * Synchronize shifted product_ids in stock_count_items table based on item_code.
     */
    private function syncStockCountItemsProductIds($stock_count)
    {
        DB::update("
            UPDATE stock_count_items sci
            LEFT JOIN product_variants pv ON pv.item_code = sci.item_code
            LEFT JOIN products p ON p.code = sci.item_code
            SET sci.product_id = COALESCE(pv.product_id, p.id)
            WHERE sci.stock_count_id = :stock_count_id
              AND (pv.product_id IS NOT NULL OR p.id IS NOT NULL)
        ", ['stock_count_id' => $stock_count->id]);
    }

    /**
     * Clean up duplicate rows in product_warehouse and product_variants.
     */
    private function cleanDuplicateWarehousesAndVariants($stock_count)
    {
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

        $variant_duplicates = DB::table('product_variants')
            ->select('item_code', DB::raw('MIN(id) as keep_id'))
            ->groupBy('item_code')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($variant_duplicates as $dup) {
            DB::table('product_variants')
                ->where('item_code', $dup->item_code)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }
    }

    /**
     * Deduct sold products stock from counted quantities if they occurred after counting.
     */
    private function deductSoldProductsStock($stock_count)
    {
        $countedItemsSubquery = DB::table('stock_count_items')
            ->select('item_code', 'product_id', DB::raw('MAX(created_at) as last_counted_at'))
            ->where('stock_count_id', $stock_count->id)
            ->groupBy('item_code', 'product_id');

        $soldProducts = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_sales.product_id', '=', 'product_variants.product_id')
                     ->on('product_sales.variant_id', '=', 'product_variants.variant_id');
            })
            ->joinSub($countedItemsSubquery, 'sci', function($join) {
                $join->on('product_sales.product_id', '=', 'sci.product_id')
                     ->whereRaw('(product_variants.item_code = sci.item_code OR (product_sales.variant_id IS NULL AND products.code = sci.item_code))');
            })
            ->where('sales.warehouse_id', $stock_count->warehouse_id)
            ->where('sales.created_at', '>=', $stock_count->created_at)
            ->whereColumn('sales.created_at', '>=', 'sci.last_counted_at')
            ->select(
                DB::raw('COALESCE(product_variants.item_code, products.code) as item_code'),
                DB::raw('SUM(product_sales.qty) as sold_qty')
            )
            ->groupBy('item_code')
            ->get();

        foreach ($soldProducts as $sold) {
            DB::table('stock_count_items')
                ->where('stock_count_id', $stock_count->id)
                ->where('item_code', $sold->item_code)
                ->update([
                    'updated_quantity' => DB::raw("GREATEST(0, updated_quantity - " . floatval($sold->sold_qty) . ")")
                ]);
        }
    }

    /**
     * Deduct waste products stock from counted quantities if they occurred after counting.
     */
    private function deductWasteProductsStock($stock_count)
    {
        $countedItemsSubquery = DB::table('stock_count_items')
            ->select('product_id', DB::raw('MAX(created_at) as last_counted_at'))
            ->where('stock_count_id', $stock_count->id)
            ->groupBy('product_id');

        $wasteProducts = WasteItem::join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
            ->join('products', 'waste_items.product_id', '=', 'products.id')
            ->joinSub($countedItemsSubquery, 'sci', function($join) {
                $join->on('waste_items.product_id', '=', 'sci.product_id');
            })
            ->where('wastes.created_at', '>=', $stock_count->created_at)
            ->whereColumn('wastes.created_at', '>=', 'sci.last_counted_at')
            ->select(
                'waste_items.product_id',
                DB::raw('SUM(waste_items.qty) as waste_qty')
            )
            ->groupBy('waste_items.product_id')
            ->get();

        foreach ($wasteProducts as $waste) {
            $qty_to_deduct = floatval($waste->waste_qty);

            $counted_items = DB::table('stock_count_items')
                ->where('stock_count_id', $stock_count->id)
                ->where('product_id', $waste->product_id)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($counted_items as $item) {
                if ($qty_to_deduct <= 0) {
                    break;
                }
                $current_qty = floatval($item->updated_quantity);
                $deducted = min($current_qty, $qty_to_deduct);

                DB::table('stock_count_items')
                    ->where('id', $item->id)
                    ->update([
                        'updated_quantity' => $current_qty - $deducted
                    ]);

                $qty_to_deduct -= $deducted;
            }

            if ($qty_to_deduct > 0 && $counted_items->isNotEmpty()) {
                DB::table('stock_count_items')
                    ->where('id', $counted_items->first()->id)
                    ->update([
                        'updated_quantity' => 0
                    ]);
            }
        }
    }

    /**
     * Process batch of resolved stock count items update.
     */
    private function processBatchUpdates($stock_count, array $batch)
    {
        foreach ($batch as $data) {
            $item_code = $data['code'];
            if ($data['action'] === 'cancel') {
                DB::table('stock_count_items')->where('stock_count_id', $stock_count->id)->where('item_code', $item_code)->delete();
                continue;
            }
            if ($data['action'] !== 'update_stock') {
                continue;
            }

            // Get the counted item details
            $stock_count_items = DB::table('stock_count_items')
                ->where('stock_count_id', $stock_count->id)
                ->where('item_code', $item_code)
                ->get();

            if ($stock_count_items->isEmpty()) {
                continue;
            }

            $counted_qty = $stock_count_items->sum('updated_quantity');

            // Clean up duplicate stock_count_items to keep only one row with the summed quantity
            if ($stock_count_items->count() > 1) {
                $first_item = $stock_count_items->sortByDesc('id')->first();
                DB::table('stock_count_items')
                    ->where('stock_count_id', $stock_count->id)
                    ->where('item_code', $item_code)
                    ->where('id', '!=', $first_item->id)
                    ->delete();

                DB::table('stock_count_items')
                    ->where('id', $first_item->id)
                    ->update(['updated_quantity' => $counted_qty]);
            } else {
                $first_item = $stock_count_items->first();
            }

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

            if (!$product) {
                continue;
            }

            $new_qty = max(0, $counted_qty);

            // Update Product_Warehouse record
            if ($variant_id) {
                $warehouse_product = Product_Warehouse::FindProductWithVariant($product->id, $variant_id, $stock_count->warehouse_id)->first();
            } else {
                $warehouse_product = Product_Warehouse::FindProductWithoutVariant($product->id, $stock_count->warehouse_id)->first();
            }

            if ($warehouse_product) {
                $warehouse_product->qty = $new_qty;
                $warehouse_product->save();
            } else {
                $warehouse_product = new Product_Warehouse();
                $warehouse_product->product_id = $product->id;
                $warehouse_product->variant_id = $variant_id;
                $warehouse_product->warehouse_id = $stock_count->warehouse_id;
                $warehouse_product->qty = $new_qty;
                $warehouse_product->save();
            }
        }
    }

    /**
     * Recalculate global product stocks in bulk.
     */
    private function recalculateGlobalStocks()
    {
        DB::statement("
            UPDATE product_variants pv
            JOIN (
                SELECT product_id, variant_id, SUM(qty) as sum_qty
                FROM product_warehouse
                GROUP BY product_id, variant_id
            ) pw ON pv.product_id = pw.product_id AND pv.variant_id = pw.variant_id
            SET pv.qty = GREATEST(0, pw.sum_qty)
        ");

        DB::statement("
            UPDATE products p
            JOIN (
                SELECT product_id, SUM(qty) as sum_qty
                FROM product_variants
                GROUP BY product_id
            ) pv ON p.id = pv.product_id
            SET p.qty = GREATEST(0, pv.sum_qty)
            WHERE p.type = 'standard'
        ");

        DB::statement("
            UPDATE products p
            JOIN (
                SELECT product_id, SUM(qty) as sum_qty
                FROM product_warehouse
                WHERE variant_id IS NULL
                GROUP BY product_id
            ) pw ON p.id = pw.product_id
            SET p.qty = GREATEST(0, pw.sum_qty)
            WHERE p.type = 'standard' AND NOT EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = p.id)
        ");
    }

    /**
     * Zero out uncounted products stock in this warehouse.
     */
    private function zeroRemainingProductsStock($stock_count)
    {
        // Get all counted item codes and resolve their current product IDs using item_code
        $counted_items = DB::table('stock_count_items')
            ->where('stock_count_id', $stock_count->id)
            ->select('product_id', 'item_code')
            ->get();

        $counted_item_codes = $counted_items->pluck('item_code')->unique()->toArray();

        $counted_variants = ProductVariant::whereIn('item_code', $counted_item_codes)->pluck('variant_id')->toArray();
        $counted_variant_product_ids = ProductVariant::whereIn('item_code', $counted_item_codes)->pluck('product_id')->toArray();

        $counted_standard_product_ids = Product::whereIn('code', $counted_item_codes)->pluck('id')->toArray();
        $counted_product_ids = array_unique(array_merge($counted_variant_product_ids, $counted_standard_product_ids));

        // Insert missing product_warehouse records for variants (so they exist in this warehouse)
        $missing_variants = DB::table('product_variants as pv')
            ->leftJoin('product_warehouse as pw', function($join) use ($stock_count) {
                $join->on('pv.product_id', '=', 'pw.product_id')
                     ->on('pv.variant_id', '=', 'pw.variant_id')
                     ->where('pw.warehouse_id', '=', $stock_count->warehouse_id);
            })
            ->whereNull('pw.id')
            ->select('pv.product_id', 'pv.variant_id')
            ->get();

        $insertDataVariants = [];
        foreach ($missing_variants as $mv) {
            $insertDataVariants[] = [
                'product_id' => $mv->product_id,
                'variant_id' => $mv->variant_id,
                'warehouse_id' => $stock_count->warehouse_id,
                'qty' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        foreach (array_chunk($insertDataVariants, 500) as $chunk) {
            DB::table('product_warehouse')->insert($chunk);
        }

        // Insert missing product_warehouse records for standard products without variants
        $missing_products = DB::table('products as p')
            ->leftJoin('product_warehouse as pw', function($join) use ($stock_count) {
                $join->on('p.id', '=', 'pw.product_id')
                     ->whereNull('pw.variant_id')
                     ->where('pw.warehouse_id', '=', $stock_count->warehouse_id);
            })
            ->leftJoin('product_variants as pv', 'p.id', '=', 'pv.product_id')
            ->whereNull('pw.id')
            ->whereNull('pv.id')
            ->where('p.is_active', true)
            ->where('p.type', 'standard')
            ->select('p.id')
            ->get();

        $insertDataProducts = [];
        foreach ($missing_products as $mp) {
            $insertDataProducts[] = [
                'product_id' => $mp->id,
                'variant_id' => null,
                'warehouse_id' => $stock_count->warehouse_id,
                'qty' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        foreach (array_chunk($insertDataProducts, 500) as $chunk) {
            DB::table('product_warehouse')->insert($chunk);
        }

        // Zero out uncounted variants & standard products in this warehouse
        DB::update("
            UPDATE product_warehouse pw
            SET pw.qty = 0
            WHERE pw.warehouse_id = :warehouse_id
              AND pw.variant_id IS NOT NULL
              AND NOT EXISTS (
                  SELECT 1 FROM stock_count_items sci
                  JOIN product_variants pv ON pv.product_id = pw.product_id AND pv.variant_id = pw.variant_id
                  WHERE sci.stock_count_id = :stock_count_id
                    AND sci.item_code = pv.item_code
              )
        ", [
            'warehouse_id' => $stock_count->warehouse_id,
            'stock_count_id' => $stock_count->id
        ]);

        DB::update("
            UPDATE product_warehouse pw
            SET pw.qty = 0
            WHERE pw.warehouse_id = :warehouse_id
              AND pw.variant_id IS NULL
              AND NOT EXISTS (
                  SELECT 1 FROM stock_count_items sci
                  JOIN products p ON p.id = pw.product_id
                  WHERE sci.stock_count_id = :stock_count_id
                    AND sci.item_code = p.code
              )
        ", [
            'warehouse_id' => $stock_count->warehouse_id,
            'stock_count_id' => $stock_count->id
        ]);

        // Zero out any remaining negative warehouse quantities
        DB::table('product_warehouse')
            ->where('warehouse_id', $stock_count->warehouse_id)
            ->where('qty', '<', 0)
            ->update(['qty' => 0]);

        // Bulk recalculate global stocks in product_variants and products tables
        $this->recalculateGlobalStocks();
    }
}

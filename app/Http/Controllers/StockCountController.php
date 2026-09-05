<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Enums\ProductType;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\Warehouse;
use App\Http\Requests\StockCount\StoreStockCountRequest;
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
        if (!$stock_count) return [];

        $query = Product::ActiveStandard()
            ->join('product_warehouse', 'products.id', 'product_warehouse.product_id');

        if ($stock_count->warehouse_id) {
            $query->where('product_warehouse.warehouse_id', $stock_count->warehouse_id);
        }

        return $query->select('products.id', 'products.name', 'products.code')
            ->groupBy('products.id')
            ->get();
    }

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

        if (!$product) {
            return response()->json([]);
        }

        $activeWarehouses = Warehouse::where('is_active', true)->get();
        if ($stock_count->warehouse_id) {
            $activeWarehouses = $activeWarehouses->where('id', $stock_count->warehouse_id);
        }

        $products = [];

        if ($product->is_variant) {
            $variants = ProductVariant::where('product_id', $product->id)->orderBy('position')->get();
            $pwRecords = DB::table('product_warehouse')
                ->where('product_id', $product->id)
                ->whereIn('warehouse_id', $activeWarehouses->pluck('id'))
                ->get();

            foreach ($variants as $variant) {
                $itemCode = $variant->item_code;
                $exists = StockCountItem::where('stock_count_id', $stock_count->id)
                    ->where('item_code', $itemCode)
                    ->exists();

                $whList = [];
                $totalQty = 0;
                foreach ($activeWarehouses as $wh) {
                    $pw = $pwRecords->first(function ($item) use ($variant, $wh) {
                        return $item->variant_id == $variant->variant_id && $item->warehouse_id == $wh->id;
                    });
                    $current_wh_qty = $pw ? floatval($pw->qty) : 0;
                    $whList[] = [
                        'warehouse_id' => $wh->id,
                        'warehouse_name' => $wh->name,
                        'qty' => $current_wh_qty
                    ];
                    $totalQty += $current_wh_qty;
                }

                $products[] = [
                    'name' => $product->name,
                    'code' => $itemCode,
                    'qty' => $totalQty,
                    'id' => $product->id,
                    'exists' => $exists,
                    'warehouses' => $whList
                ];
            }
        } else {
            $pwRecords = DB::table('product_warehouse')
                ->where('product_id', $product->id)
                ->whereNull('variant_id')
                ->whereIn('warehouse_id', $activeWarehouses->pluck('id'))
                ->get();

            $itemCode = $product->code;
            $exists = StockCountItem::where('stock_count_id', $stock_count->id)
                ->where('item_code', $itemCode)
                ->exists();

            $whList = [];
            $totalQty = 0;
            foreach ($activeWarehouses as $wh) {
                $pw = $pwRecords->first(function ($item) use ($wh) {
                    return $item->warehouse_id == $wh->id;
                });
                $current_wh_qty = $pw ? floatval($pw->qty) : 0;
                $whList[] = [
                    'warehouse_id' => $wh->id,
                    'warehouse_name' => $wh->name,
                    'qty' => $current_wh_qty
                ];
                $totalQty += $current_wh_qty;
            }

            $products[] = [
                'name' => $product->name,
                'code' => $itemCode,
                'qty' => $totalQty,
                'id' => $product->id,
                'exists' => $exists,
                'warehouses' => $whList
            ];
        }

        return response()->json($products);
    }

    public function store(StoreStockCountRequest $request)
    {
        $stock_count = new StockCount();
        $stock_count->warehouse_id = ($request->warehouse_id === 'all' || empty($request->warehouse_id)) ? null : $request->warehouse_id;
        $stock_count->save();
        return redirect()->route('stock-count.show', $stock_count->id);
    }

    public function update(Request $request, $id)
    {
        $stock_count = StockCount::findOrFail($id);
        if ($request->status === 'add') {
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    if (($item['qty'] ?? 0) == 0 && ($item['current_qty'] ?? 0) == 0) {
                        continue;
                    }
                    DB::table('stock_count_items')->insert([
                        'stock_count_id' => $stock_count->id,
                        'warehouse_id' => $item['warehouse_id'] ?? $stock_count->warehouse_id,
                        'product_id' => $item['product_id'],
                        'item_code' => $item['code'],
                        'current_quantity' => $item['current_qty'] ?? 0,
                        'updated_quantity' => $item['qty'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } elseif ($request->has('product_code')) {
                foreach ($request['product_code'] as $key => $product_code) {
                    if ($request['qty'][$key] == 0 && $request['current_qty'][$key] == 0)
                        continue;
                    DB::table('stock_count_items')->insert([
                        'stock_count_id' => $stock_count->id,
                        'warehouse_id' => isset($request['warehouse_id'][$key]) ? $request['warehouse_id'][$key] : $stock_count->warehouse_id,
                        'product_id' => $request['product_id'][$key],
                        'item_code' => $request['product_code'][$key],
                        'current_quantity' => $request['current_qty'][$key],
                        'updated_quantity' => $request['qty'][$key],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
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
                if (is_string($batch)) {
                    $batch = json_decode($batch, true);
                }
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
                        'is_completed' => true,
                        'is_resolved' => true,
                        'resolved_by' => Auth::id(),
                        'completed_by' => $stock_count->completed_by ?: Auth::id()
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
            $lims_stock_count = StockCount::with(['items.product', 'items.warehouse', 'warehouse'])->find($id);
            if (!$lims_stock_count) {
                abort(404);
            }

            $lims_warehouse_list = Warehouse::where('is_active', true)->get();

            $itemsGrouped = collect($lims_stock_count->items)->groupBy('item_code');
            $lims_stock_count->setRelation('items', $itemsGrouped);

            $getCurrentQty = function($items) {
                return $items->groupBy('warehouse_id')->map(function($whItems) {
                    return floatval($whItems->first()->current_quantity);
                })->sum();
            };

            // 1. Calculate Stock Matched, Over Stock, Under Stock
            $stockMatched = $itemsGrouped->filter(function ($items) use ($getCurrentQty) {
                $total_counted = $items->sum('updated_quantity');
                $total_current = $getCurrentQty($items);
                return $total_counted == $total_current;
            });

            $overStock = $itemsGrouped->filter(function ($items) use ($getCurrentQty) {
                $total_counted = $items->sum('updated_quantity');
                $total_current = $getCurrentQty($items);
                return $total_counted > $total_current;
            });

            $underStock = $itemsGrouped->filter(function ($items) use ($getCurrentQty) {
                $total_counted = $items->sum('updated_quantity');
                $total_current = $getCurrentQty($items);
                return $total_counted < $total_current;
            });

            // 2. Statistics sums
            $matchedCountQty = 0;
            foreach ($stockMatched as $items) {
                $matchedCountQty += $items->sum('updated_quantity');
            }

            $overCountQty = 0;
            $overFindQty = 0;
            foreach ($overStock as $items) {
                $total_current = $getCurrentQty($items);
                $total_counted = $items->sum('updated_quantity');
                $overCountQty += ($total_counted - $total_current);
                $overFindQty += $total_counted;
            }

            $underCountQty = 0;
            $underFindQty = 0;
            foreach ($underStock as $items) {
                $total_current = $getCurrentQty($items);
                $total_counted = $items->sum('updated_quantity');
                $underCountQty += ($total_current - $total_counted);
                $underFindQty += $total_counted;
            }

            $totalCountedQty = $lims_stock_count->items->flatten()->sum('updated_quantity');

            // 3. Counted product IDs
            $counted_product_ids = $lims_stock_count->items->flatten()->pluck('product_id')->filter()->unique()->values()->toArray();
            $totalCountedProducts = count($counted_product_ids);

            // 4. Remaining Products Count & Qty
            $remainingQuery = DB::table('product_warehouse')
                ->join('products', 'products.id', '=', 'product_warehouse.product_id')
                ->where('product_warehouse.qty', '>', 0)
                ->where('products.is_active', true)
                ->where('products.type', ProductType::STANDARD->value)
                ->whereNotIn('products.id', $counted_product_ids);

            if ($lims_stock_count->warehouse_id) {
                $remainingQuery->where('product_warehouse.warehouse_id', $lims_stock_count->warehouse_id);
            }

            $remainingCount = (clone $remainingQuery)->distinct()->count('products.id');
            $remainingQty = (clone $remainingQuery)->sum('product_warehouse.qty');

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
                ->where('sales.created_at', '>=', $lims_stock_count->created_at)
                ->whereColumn('sales.created_at', '>=', 'sci.last_counted_at');

            if ($lims_stock_count->warehouse_id) {
                $soldQuery->where('sales.warehouse_id', $lims_stock_count->warehouse_id);
            }

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
                'lims_warehouse_list',
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
            $lims_stock_count = StockCount::with(['items', 'warehouse'])->findOrFail($id);
            $counted_product_ids = $lims_stock_count->items->pluck('product_id')->unique()->toArray();

            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = Category::with('parent')->where('is_active', true)->get();

            $brand_id = request()->input('brand_id', 0);
            $category_id = request()->input('category_id', 0);
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $query = Product::ActiveStandard()
                ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
                ->where('product_warehouse.qty', '>', 0);

            if ($lims_stock_count->warehouse_id) {
                $query->where('product_warehouse.warehouse_id', $lims_stock_count->warehouse_id);
            }

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

            $remainingProducts = $query->select('products.id', 'products.name', 'products.code', 'products.price', 'products.cost', DB::raw('SUM(product_warehouse.qty) as qty'))
                ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'products.cost')
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
                ->where('sales.created_at', '>=', $lims_stock_count->created_at)
                ->whereColumn('sales.created_at', '>=', 'sci.last_counted_at');

            if ($lims_stock_count->warehouse_id) {
                $query->where('sales.warehouse_id', $lims_stock_count->warehouse_id);
            }

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
            return redirect()->route('stock-count.show', $id)->with('not_permitted', 'Cannot revert this stock count.');
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
     * Clean duplicate product_warehouse records to enforce standard structure (1 row per product-variant-warehouse).
     */
    private function cleanDuplicateWarehousesAndVariants($stock_count)
    {
        $warehouse_duplicates_query = DB::table('product_warehouse')
            ->select('product_id', 'warehouse_id', 'variant_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('product_id', 'warehouse_id', 'variant_id')
            ->havingRaw('COUNT(*) > 1');

        if ($stock_count->warehouse_id) {
            $warehouse_duplicates_query->where('warehouse_id', $stock_count->warehouse_id);
        }

        $warehouse_duplicates = $warehouse_duplicates_query->get();

        foreach ($warehouse_duplicates as $dup) {
            $query = DB::table('product_warehouse')
                ->where('product_id', $dup->product_id)
                ->where('warehouse_id', $dup->warehouse_id)
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
            ->select('item_code', 'product_id', 'warehouse_id', DB::raw('MAX(created_at) as last_counted_at'))
            ->where('stock_count_id', $stock_count->id)
            ->groupBy('item_code', 'product_id', 'warehouse_id');

        $soldQuery = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_sales.product_id', '=', 'product_variants.product_id')
                     ->on('product_sales.variant_id', '=', 'product_variants.variant_id');
            })
            ->joinSub($countedItemsSubquery, 'sci', function($join) {
                $join->on('product_sales.product_id', '=', 'sci.product_id')
                     ->whereRaw('(product_variants.item_code = sci.item_code OR (product_sales.variant_id IS NULL AND products.code = sci.item_code))')
                     ->whereRaw('(sci.warehouse_id IS NULL OR sales.warehouse_id = sci.warehouse_id)');
            })
            ->where('sales.created_at', '>=', $stock_count->created_at)
            ->whereColumn('sales.created_at', '>=', 'sci.last_counted_at');

        if ($stock_count->warehouse_id) {
            $soldQuery->where('sales.warehouse_id', $stock_count->warehouse_id);
        }

        $soldProducts = $soldQuery->select(
            DB::raw('COALESCE(product_variants.item_code, products.code) as item_code'),
            'sales.warehouse_id',
            DB::raw('SUM(product_sales.qty) as sold_qty')
        )
        ->groupBy('item_code', 'sales.warehouse_id')
        ->get();

        foreach ($soldProducts as $sold) {
            $q = DB::table('stock_count_items')
                ->where('stock_count_id', $stock_count->id)
                ->where('item_code', $sold->item_code);
            if ($sold->warehouse_id) {
                $q->where(function($subQ) use ($sold) {
                    $subQ->where('warehouse_id', $sold->warehouse_id)->orWhereNull('warehouse_id');
                });
            }
            $q->update([
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
                    $product = Product::find($stock_count_items->first()->product_id);
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

            if ($stock_count->warehouse_id) {
                // Single warehouse stock count
                $counted_qty = $stock_count_items->sum('updated_quantity');
                $new_qty = max(0, $counted_qty);

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
            } else {
                // Multi warehouse stock count: Group by warehouse_id
                $byWarehouse = $stock_count_items->groupBy('warehouse_id');
                foreach ($byWarehouse as $wh_id => $itemsGroup) {
                    $target_wh_id = $wh_id;
                    if (!$target_wh_id) {
                        $defWh = Warehouse::where('is_default', 1)->first() ?? Warehouse::first();
                        $target_wh_id = $defWh ? $defWh->id : 1;
                    }
                    $wh_qty = max(0, $itemsGroup->sum('updated_quantity'));

                    if ($variant_id) {
                        $warehouse_product = Product_Warehouse::FindProductWithVariant($product->id, $variant_id, $target_wh_id)->first();
                    } else {
                        $warehouse_product = Product_Warehouse::FindProductWithoutVariant($product->id, $target_wh_id)->first();
                    }

                    if ($warehouse_product) {
                        $warehouse_product->qty = $wh_qty;
                        $warehouse_product->save();
                    } else {
                        $warehouse_product = new Product_Warehouse();
                        $warehouse_product->product_id = $product->id;
                        $warehouse_product->variant_id = $variant_id;
                        $warehouse_product->warehouse_id = $target_wh_id;
                        $warehouse_product->qty = $wh_qty;
                        $warehouse_product->save();
                    }
                }
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
            WHERE p.type = '" . ProductType::STANDARD->value . "'
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
            WHERE p.type = '" . ProductType::STANDARD->value . "' AND NOT EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = p.id)
        ");
    }

    /**
     * Zero out uncounted products stock in this warehouse.
     */
    private function zeroRemainingProductsStock($stock_count)
    {
        // 1. Get all counted item codes BEFORE inserting zeroed records
        $counted_items = DB::table('stock_count_items')
            ->where('stock_count_id', $stock_count->id)
            ->select('product_id', 'item_code')
            ->get();

        $counted_item_codes = $counted_items->pluck('item_code')->filter()->unique()->toArray();

        // 2. Capture all uncounted variants with stock > 0
        $uncountedVariantsQuery = DB::table('product_warehouse as pw')
            ->join('product_variants as pv', function($join) {
                $join->on('pv.product_id', '=', 'pw.product_id')
                     ->on('pv.variant_id', '=', 'pw.variant_id');
            })
            ->where('pw.qty', '>', 0)
            ->whereNotNull('pw.variant_id')
            ->whereNotIn('pv.item_code', $counted_item_codes);

        if ($stock_count->warehouse_id) {
            $uncountedVariantsQuery->where('pw.warehouse_id', $stock_count->warehouse_id);
        }

        $uncountedVariants = $uncountedVariantsQuery->select(
            'pw.id as pw_id',
            'pw.warehouse_id',
            'pw.product_id',
            'pv.item_code',
            'pw.qty as current_qty'
        )->get();

        // 3. Capture all uncounted standard products (without variants) with stock > 0
        $uncountedProductsQuery = DB::table('product_warehouse as pw')
            ->join('products as p', 'p.id', '=', 'pw.product_id')
            ->where('pw.qty', '>', 0)
            ->whereNull('pw.variant_id')
            ->where('p.is_active', true)
            ->where('p.type', ProductType::STANDARD->value)
            ->whereNotIn('p.code', $counted_item_codes);

        if ($stock_count->warehouse_id) {
            $uncountedProductsQuery->where('pw.warehouse_id', $stock_count->warehouse_id);
        }

        $uncountedProducts = $uncountedProductsQuery->select(
            'pw.id as pw_id',
            'pw.warehouse_id',
            'pw.product_id',
            'p.code as item_code',
            'pw.qty as current_qty'
        )->get();

        // 4. Record uncounted items into stock_count_items with updated_quantity = 0 so the loss/zeroing is permanently tracked
        $allUncounted = $uncountedVariants->concat($uncountedProducts);
        $zeroedItemsToInsert = [];
        foreach ($allUncounted as $uncounted) {
            $zeroedItemsToInsert[] = [
                'stock_count_id' => $stock_count->id,
                'warehouse_id' => $uncounted->warehouse_id,
                'product_id' => $uncounted->product_id,
                'item_code' => $uncounted->item_code,
                'current_quantity' => $uncounted->current_qty,
                'updated_quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        foreach (array_chunk($zeroedItemsToInsert, 500) as $chunk) {
            DB::table('stock_count_items')->insert($chunk);
        }

        // 5. Directly set product_warehouse qty = 0 for all uncounted items!
        $pwIdsToZero = $allUncounted->pluck('pw_id')->filter()->toArray();
        if (!empty($pwIdsToZero)) {
            foreach (array_chunk($pwIdsToZero, 500) as $chunk) {
                DB::table('product_warehouse')->whereIn('id', $chunk)->update(['qty' => 0, 'updated_at' => now()]);
            }
        }

        // 6. Also ensure any other uncounted variant or product in target warehouse(s) is 0
        if ($stock_count->warehouse_id) {
            DB::table('product_warehouse as pw')
                ->join('product_variants as pv', function($join) {
                    $join->on('pv.product_id', '=', 'pw.product_id')
                         ->on('pv.variant_id', '=', 'pw.variant_id');
                })
                ->where('pw.warehouse_id', $stock_count->warehouse_id)
                ->whereNotNull('pw.variant_id')
                ->whereNotIn('pv.item_code', $counted_item_codes)
                ->update(['pw.qty' => 0, 'pw.updated_at' => now()]);

            DB::table('product_warehouse as pw')
                ->join('products as p', 'p.id', '=', 'pw.product_id')
                ->where('pw.warehouse_id', $stock_count->warehouse_id)
                ->whereNull('pw.variant_id')
                ->whereNotIn('p.code', $counted_item_codes)
                ->update(['pw.qty' => 0, 'pw.updated_at' => now()]);

            DB::table('product_warehouse')
                ->where('warehouse_id', $stock_count->warehouse_id)
                ->where('qty', '<', 0)
                ->update(['qty' => 0, 'updated_at' => now()]);
        } else {
            DB::table('product_warehouse as pw')
                ->join('product_variants as pv', function($join) {
                    $join->on('pv.product_id', '=', 'pw.product_id')
                         ->on('pv.variant_id', '=', 'pw.variant_id');
                })
                ->whereNotNull('pw.variant_id')
                ->whereNotIn('pv.item_code', $counted_item_codes)
                ->update(['pw.qty' => 0, 'pw.updated_at' => now()]);

            DB::table('product_warehouse as pw')
                ->join('products as p', 'p.id', '=', 'pw.product_id')
                ->whereNull('pw.variant_id')
                ->whereNotIn('p.code', $counted_item_codes)
                ->update(['pw.qty' => 0, 'pw.updated_at' => now()]);

            DB::table('product_warehouse')
                ->where('qty', '<', 0)
                ->update(['qty' => 0, 'updated_at' => now()]);
        }

        // 7. Bulk recalculate global stocks in product_variants and products tables
        $this->recalculateGlobalStocks();
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete stock count');
        }

        StockCountItem::where('stock_count_id', $id)->delete();
        $stockCount = StockCount::find($id);
        if ($stockCount) {
            $stockCount->delete();
        }

        return redirect()->back()->with('not_permitted', 'Stock count deleted successfully');
    }
}

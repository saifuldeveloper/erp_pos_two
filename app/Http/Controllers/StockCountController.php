<?php

namespace App\Http\Controllers;

use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\Warehouse;
use App\Models\Brand;
use App\Models\Category;
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
                        $diff = $counted_qty - $saved_qty;

                        $product = Product::find($first_item->product_id);
                        if (!$product)
                            continue;

                        $variant_id = null;
                        $productVariant = ProductVariant::where('item_code', $item_code)->first();
                        if ($productVariant) {
                            $variant_id = $productVariant->variant_id;
                        }

                        // 1. Update Product_Warehouse record
                        if ($variant_id) {
                            $warehouse_product = Product_Warehouse::FindProductWithVariant($product->id, $variant_id, $stock_count->warehouse_id)->first();
                        } else {
                            $warehouse_product = Product_Warehouse::FindProductWithoutVariant($product->id, $stock_count->warehouse_id)->first();
                        }

                        if ($warehouse_product) {
                            $warehouse_product->qty = max(0, $warehouse_product->qty + $diff);
                            $warehouse_product->save();
                        } else {
                            // If it didn't exist in this warehouse, create it with the counted quantity
                            $warehouse_product = new Product_Warehouse();
                            $warehouse_product->product_id = $product->id;
                            $warehouse_product->variant_id = $variant_id;
                            $warehouse_product->warehouse_id = $stock_count->warehouse_id;
                            $warehouse_product->qty = max(0, $counted_qty);
                            $warehouse_product->save();
                        }

                        // 2. Update Global stock
                        if ($productVariant) {
                            $productVariant->qty = max(0, $productVariant->qty + $diff);
                            $productVariant->save();

                            // Recalculate main product's global stock (sum of all its variants' global stocks)
                            $total_variant_qty = ProductVariant::where('product_id', $product->id)->sum('qty');
                            $product->qty = max(0, $total_variant_qty);
                            $product->save();
                        } else {
                            $product->qty = max(0, $product->qty + $diff);
                            $product->save();
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
            
            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = Category::with('parent')->where('is_active', true)->get();

            $brand_id = request()->input('brand_id', 0);
            $category_id = request()->input('category_id', 0);
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $query = \App\Models\Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
                ->join('products', 'product_sales.product_id', '=', 'products.id')
                ->leftJoin('product_variants', function($join) {
                    $join->on('product_sales.product_id', '=', 'product_variants.product_id')
                         ->on('product_sales.variant_id', '=', 'product_variants.variant_id');
                })
                ->where('sales.warehouse_id', $lims_stock_count->warehouse_id)
                ->where('sales.created_at', '>=', $lims_stock_count->created_at);

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

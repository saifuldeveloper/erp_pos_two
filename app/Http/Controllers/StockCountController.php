<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StockCount;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\Variant;
use DB;
use Auth;
use Spatie\Permission\Models\Role;

class StockCountController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $general_setting = DB::table('general_settings')->latest()->first();
            $lims_stock_count_all = StockCount::orderBy('id', 'desc')
                ->when($request->starting_date, function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->starting_date);
                })
                ->when($request->ending_date, function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->ending_date);
                })
                ->get();
            $count = [];
            $total_qty = 0;
            $total_price = 0;
            $total_cost = 0;
            foreach ($lims_stock_count_all as $stock_count) {
                foreach ($stock_count->items as $item) {
                    $product = $item->product;
                    $total_qty += $product->qty;
                    $total_price += $product->price * $product->qty;
                    $total_cost += $product->cost * $product->qty;
                }
            }
            $count['total_qty'] = $total_qty;
            $count['total_price'] = $total_price;
            $count['total_cost'] = $total_cost;
            return view('backend.stock_count.index', compact('lims_warehouse_list', 'lims_stock_count_all', 'count'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('purchases-add')) {
            $stock_count = StockCount::where('is_completed', false)->orWhere('is_resolved', false)->first();
            if ($stock_count) {
                return redirect()->route('stock-count.show', $stock_count->id);
            }
            return view('backend.stock_count.create');
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function product()
    {
        return Product::ActiveStandard()->select('id', 'name', 'code')->get();
    }

    public function productSearch(Request $request)
    {
        $product_code = explode("|", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $product = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])
            ->first();
        if ($product && $product->is_variant) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')

                ->where([
                    ['product_variants.product_id', $product->id],
                    ['products.is_active', true]
                ])
                ->select('products.*', 'product_variants.item_code', 'product_variants.qty')
                ->get();
        } else {
            $lims_product_data = Product::where([
                ['code', $product_code[0]],
                ['is_active', true]
            ])
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
        $stock_count->save();
        return redirect()->route('stock-count.show', $stock_count->id);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_stock_count = StockCount::find($id);
            return view('backend.stock_count.edit', compact('lims_warehouse_list', 'lims_stock_count'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        if ($request->status == 'add') {
            $stock_count = StockCount::find($id);
            foreach ($request['product_code'] as $key => $product_code) {
                if ($request['qty'][$key] == 0) {
                    continue;
                }
                DB::table('stock_count_items')->insert([
                    'stock_count_id' => $stock_count->id,
                    'product_id' => $request['product_id'][$key],
                    'item_code' => $request['product_code'][$key],
                    'current_quantity' => $request['current_qty'][$key],
                    'updated_quantity' => $request['qty'][$key],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } elseif ($request->status == 'complete') {
            $stock_count = StockCount::find($id);
            $stock_count->is_completed = true;
            $stock_count->save();
        }elseif ($request->status == 'resolved') {
            dd($request->all());
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
            } else {
                return view('backend.stock_count.show_for_resolved', compact('lims_stock_count'));
            }
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}

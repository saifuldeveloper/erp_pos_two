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
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('stock_count')) {
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $general_setting = DB::table('general_settings')->latest()->first();
            $lims_stock_count_all = StockCount::orderBy('id', 'desc')->get();
            return view('backend.stock_count.index', compact('lims_warehouse_list', 'lims_stock_count_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('purchases-add')) {
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_product_list = $this->product();
            return view('backend.stock_count.create', compact('lims_warehouse_list', 'lims_product_list'));
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
        $data = $request->all();
        $stock_count = new StockCount();
        $stock_count->warehouse_id = $data['warehouse_id'];
        $stock_count->user_id = Auth::id();
        $stock_count->note = $data['note'];
        $stock_count->save();

        foreach ($data['product_code'] as $key => $product_code) {
            DB::table('stock_count_items')->insert([
                'stock_count_id' => $stock_count->id,
                'product_id' => $data['product_id'][$key],
                'item_code' => $data['product_code'][$key],
                'current_quantity' => $data['current_qty'][$key],
                'updated_quantity' => $data['qty'][$key],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $product_variant = ProductVariant::where('item_code', $data['product_code'][$key])->first();
            if ($product_variant) {
                $product_variant->qty += $data['qty'][$key];
                $product_variant->save();
            }
            $productVariant = explode('-', $data['product_code'][$key])[0];
            $variant = Variant::where('name', $productVariant)->first();
            if ($variant) {
                $productWarehouse = Product_Warehouse::where('product_id', $data['product_id'][$key])
                    ->where('variant_id', $variant->id)
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->first();
                if ($productWarehouse) {
                    $productWarehouse->qty += $data['qty'][$key];
                    $productWarehouse->save();
                }
            }
        }

        $data['product_id'] = array_unique($data['product_id']);

        foreach ($data['product_id'] as $key => $product_id) {
            $productVariantsQty = ProductVariant::where('product_id', $product_id)->sum('qty');
            $product = Product::find($product_id);
            $product->qty = $productVariantsQty;
            $product->save();
        }

        return redirect()->route('stock-count.index')->with('message', 'Stock Count created successfully! Please download the initial file to complete it.');
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
        $data = $request->all();
        $stock_count = StockCount::findOrFail($id);
        $stock_count->warehouse_id = $data['warehouse_id'];
        $stock_count->note = $data['note'];
        $stock_count->save();

        foreach ($stock_count->items as $key => $item) {
            $product_variant = ProductVariant::where('item_code', $item->item_code)->first();
            if ($product_variant) {
                $product_variant->qty -= $item->updated_quantity;
                $product_variant->save();

                $product_variant->qty += $data['qty'][$key];
                $product_variant->save();
            }
            $productVariant = explode('-', $item->item_code)[0];
            $variant = Variant::where('name', $productVariant)->first();
            if ($variant) {
                $productWarehouse = Product_Warehouse::where('product_id', $item->product_id)
                    ->where('variant_id', $variant->id)
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->first();
                if ($productWarehouse) {
                    $productWarehouse->qty -= $item->updated_quantity;
                    $productWarehouse->save();

                    $productWarehouse->qty += $data['qty'][$key];
                    $productWarehouse->save();
                }
            }

            $item->current_quantity = $data['current_qty'][$key];
            $item->updated_quantity = $data['qty'][$key];
            $item->save();
        }

        $data['product_id'] = array_unique($data['product_id']);

        foreach ($data['product_id'] as $key => $product_id) {
            $productVariantsQty = ProductVariant::where('product_id', $product_id)->sum('qty');
            $product = Product::find($product_id);
            $product->qty = $productVariantsQty;
            $product->save();
        }
        return redirect()->route('stock-count.index')->with('message', 'Stock Count updated successfully!');
    }
}

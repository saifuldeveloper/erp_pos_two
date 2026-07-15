<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use App\Models\Biller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\ProductVariant;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $start_date = $request->start_date ?? date('d-m-Y', strtotime('-30 days'));
            $end_date = $request->end_date ?? date('d-m-Y');
            $formatted_start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->format('Y-m-d');
            $formatted_end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->format('Y-m-d');
            $wastes = Waste::whereDate('created_at', '>=', $formatted_start_date)
                ->whereDate('created_at', '<=', $formatted_end_date)
                ->get();
            return view('backend.waste.index', compact('wastes', 'start_date', 'end_date'));
        }
    }

    // public function wastedata(Request $request)
    // {

    //     $columns = ['date', 'receiver_type', 'receiver_id', 'total_price'];

    //     $query = Waste::with('items.product')
    //         ->select('wastes.id', 'wastes.created_at as date', 'wastes.receiver_type', 'wastes.receiver_name', 'wastes.total_price', 'wastes.status');


    //     if ($search = $request->input('search')['value']) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('wastes.receiver_type', 'like', "%$search%")
    //                 ->orWhere('products.name', 'like', "%$search%")
    //                 ->orWhere('products.code', 'like', "%$search%");
    //         });
    //     }


    //     if ($request->input('order')) {
    //         $orderColumn = $columns[$request->input('order')[0]['column']];
    //         $orderDir = $request->input('order')[0]['dir'];
    //         $query->orderBy($orderColumn, $orderDir);
    //     }


    //     $start = $request->input('start');
    //     $length = $request->input('length');
    //     $totalRecords = $query->count();
    //     $wastes = $query->offset($start)->limit($length)->get();


    //     return response()->json([
    //         'draw' => $request->input('draw'),
    //         'recordsTotal' => $totalRecords,
    //         'recordsFiltered' => $totalRecords,
    //         'data' => $wastes,
    //     ]);
    // }

    public function wastedata(Request $request)
    {
        $columns = [
            0 => 'wastes.created_at',
            1 => 'wastes.receiver_type',
            2 => 'wastes.receiver_name',
            3 => DB::raw('(SELECT SUM(qty) FROM waste_items WHERE waste_items.waste_id = wastes.id)'),
            5 => 'wastes.total_price'
        ];
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $starting_date = $start_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->format('Y-m-d') : null;
        $ending_date = $end_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->format('Y-m-d') : null;

        $baseQuery = Waste::select(
            'wastes.id',
            'wastes.created_at as date',
            'wastes.receiver_type',
            'wastes.receiver_name',
            'wastes.total_price',
            'wastes.status',
            DB::raw('(SELECT SUM(qty) FROM waste_items WHERE waste_items.waste_id = wastes.id) as total_qty')
        )
            ->leftJoin('waste_items', 'wastes.id', '=', 'waste_items.waste_id')
            ->leftJoin('products', 'waste_items.product_id', '=', 'products.id')
            ->distinct('wastes.id');

        if ($starting_date && $ending_date) {
            $baseQuery->whereDate('wastes.created_at', '>=', $starting_date)
                      ->whereDate('wastes.created_at', '<=', $ending_date);
        }

        $query = clone $baseQuery;
        if ($search = $request->input('search')['value']) {
            $query->where(function ($q) use ($search) {
                $q->where('wastes.receiver_type', 'like', "%$search%")
                    ->orWhere('wastes.receiver_name', 'like', "%$search%")
                    ->orWhere('products.name', 'like', "%$search%")
                    ->orWhere('products.code', 'like', "%$search%");
            });
        }
        if ($request->input('order')) {
            $orderColIdx = $request->input('order')[0]['column'];
            $orderColumn = $columns[$orderColIdx] ?? 'wastes.created_at';
            $orderDir = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDir);
        }
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $totalRecords = (clone $query)->count(DB::raw('distinct wastes.id'));
        if ($length > 0) {
            $wastes = $query->offset($start)->limit($length)->get();
        } else {
            $wastes = $query->get();
        }

        $waste_ids = $wastes->pluck('id')->toArray();
        $purchaseTotals = DB::table('waste_items as wi')
            ->join('products as p', 'wi.product_id', '=', 'p.id')
            ->whereIn('wi.waste_id', $waste_ids)
            ->selectRaw('wi.waste_id, SUM(wi.qty * COALESCE(p.cost, 0)) as total')
            ->groupBy('wi.waste_id')
            ->pluck('total', 'wi.waste_id');

        foreach ($wastes as $waste) {
            $waste->purchase_price = $purchaseTotals[$waste->id] ?? 0;
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $wastes,
        ]);
    }


    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $lims_product_data = Product::where('is_active', true)->get();
            $product_qty = [];
            $product_code = [];
            $product_name = [];
            $product_type = [];
            $product_id = [];
            $product_list = [];
            $qty_list = [];
            $product_price = [];
            $batch_no = [];
            $product_batch_id = [];
            $expired_date = [];
            $is_embeded = [];

            foreach ($lims_product_data as $product) {
                $product_qty[] = $product->qty;
                $product_code[] = $product->code;
                $product_name[] = $product->name;
                $product_type[] = $product->type;
                $product_id[] = $product->id;
                $product_list[] = $product->product_list;
                $qty_list[] = $product->qty_list;
                $product_price[] = $product->price;
                $batch_no[] = null;
                $product_batch_id[] = null;
                $expired_date[] = null;
                $is_embeded[] = 0;
            }
            $products = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id, $expired_date, $is_embeded];
            return view('backend.waste.create', compact('products'));
        }
    }

    public function getReceiverList($type)
    {
        switch ($type) {
            case 'employee':
                $receivers = Employee::where('is_active', true)
                    ->select('id', 'name')
                    ->get();
                break;
            case 'customer':
                $receivers = Customer::where('is_active', true)
                    ->select('id', 'name')
                    ->get();
                break;
            case 'supplier':
                $receivers = Supplier::where('is_active', true)
                    ->select('id', 'name')
                    ->get();
                break;
            case 'biller':
                $receivers = Biller::where('is_active', true)
                    ->select('id', 'name')
                    ->get();
                break;
            default:
                $receivers = [];
                break;
        }

        return view('backend.waste.receiverlist', compact('receivers'));
    }

    public function store(Request $request)
    {
        $filtered_products = [];
        if ($request->product) {
            foreach ($request->product as $prod) {
                if (isset($prod['qty']) && (float)$prod['qty'] > 0) {
                    $filtered_products[] = $prod;
                }
            }
        }

        if (empty($filtered_products)) {
            return redirect()->back()->with('not_permitted', 'Please enter quantity for at least one item.');
        }

        DB::beginTransaction();
        try {
            // 🔹 Stock Validation (to prevent negative stock)
            foreach ($filtered_products as $data) {
                $product = Product::find($data['product_id']);
                if (isset($data['varient_code']) && $data['varient_code']) {
                    $product_variant = ProductVariant::where([
                        ['product_id', $data['product_id']],
                        ['item_code', $data['varient_code']]
                    ])->first();
                    if (!$product_variant || $product_variant->qty < $data['qty']) {
                        throw new \Exception("Cannot record waste. Product variant '{$product->name}' would have negative global stock.");
                    }
                }
                
                if ($product->qty < $data['qty']) {
                    throw new \Exception("Cannot record waste. Product '{$product->name}' would have negative global stock.");
                }
            }

            $waste = new Waste();
            $waste->receiver_type = $request->receiver_type;
            $waste->receiver_id = explode('-', $request->receiver_id)[0];
            $waste->receiver_name = explode('-', $request->receiver_id)[1];
            $waste->note = $request->note;
            $waste->total_price = $request->total;
            $waste->save();

            $waste->items()->createMany($filtered_products);

            if ($waste) {
                foreach ($filtered_products as $data) {
                    $product = Product::find($data['product_id']);
                    $product->qty -= $data['qty'];
                    $product->save();

                    if (isset($data['varient_code']) && $data['varient_code']) {
                        $product_variant = ProductVariant::where([
                            ['product_id', $data['product_id']],
                            ['item_code', $data['varient_code']]
                        ])->first();
                        if ($product_variant) {
                            $product_variant->qty -= $data['qty'];
                            $product_variant->save();
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('waste.index');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $waste = Waste::with('items.product')->find($id);
            $lims_product_data = Product::where('is_active', true)->get();
            $product_qty = [];
            $product_code = [];
            $product_name = [];
            $product_type = [];
            $product_id = [];
            $product_list = [];
            $qty_list = [];
            $product_price = [];
            $batch_no = [];
            $product_batch_id = [];
            $expired_date = [];
            $is_embeded = [];

            foreach ($lims_product_data as $product) {
                $product_qty[] = $product->qty;
                $product_code[] = $product->code;
                $product_name[] = $product->name;
                $product_type[] = $product->type;
                $product_id[] = $product->id;
                $product_list[] = $product->product_list;
                $qty_list[] = $product->qty_list;
                $product_price[] = $product->price;
                $batch_no[] = null;
                $product_batch_id[] = null;
                $expired_date[] = null;
                $is_embeded[] = 0;
            }
            $products = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id, $expired_date, $is_embeded];

            switch ($waste->receiver_type) {
                case 'employee':
                    $receivers = Employee::where('is_active', true)
                        ->select('id', 'name')
                        ->get();
                    break;
                case 'customer':
                    $receivers = Customer::where('is_active', true)
                        ->select('id', 'name')
                        ->get();
                    break;
                case 'supplier':
                    $receivers = Supplier::where('is_active', true)
                        ->select('id', 'name')
                        ->get();
                    break;
                case 'biller':
                    $receivers = Biller::where('is_active', true)
                        ->select('id', 'name')
                        ->get();
                    break;
                default:
                    $receivers = [];
                    break;
            }

            return view('backend.waste.edit', compact('waste', 'products', 'receivers'));
        }
    }

    public function update(Request $request, $id)
    {
        $filtered_products = [];
        if ($request->product) {
            foreach ($request->product as $prod) {
                if (isset($prod['qty']) && (float)$prod['qty'] > 0) {
                    $filtered_products[] = $prod;
                }
            }
        }

        if (empty($filtered_products)) {
            return redirect()->back()->with('not_permitted', 'Please enter quantity for at least one item.');
        }

        $waste = Waste::find($id);

        DB::beginTransaction();
        try {
            // 🔹 Stock Validation (to prevent negative stock)
            $old_waste_qtys = [];
            foreach ($waste->items as $item) {
                $key_item = $item->product_id . '_' . ($item->varient_code ?? '');
                $old_waste_qtys[$key_item] = ($old_waste_qtys[$key_item] ?? 0) + $item->qty;
            }

            $new_waste_qtys = [];
            foreach ($filtered_products as $data) {
                $key_item = $data['product_id'] . '_' . ($data['varient_code'] ?? '');
                $new_waste_qtys[$key_item] = ($new_waste_qtys[$key_item] ?? 0) + $data['qty'];
            }

            foreach ($all_keys = array_unique(array_merge(array_keys($old_waste_qtys), array_keys($new_waste_qtys))) as $item_key) {
                $old_qty = $old_waste_qtys[$item_key] ?? 0;
                $new_qty = $new_waste_qtys[$item_key] ?? 0;
                
                $net_deduction = $new_qty - $old_qty;
                
                if ($net_deduction > 0) {
                    $parts = explode('_', $item_key);
                    $pro_id = $parts[0];
                    $varient_code = $parts[1] !== '' ? $parts[1] : null;
                    
                    $product = Product::find($pro_id);
                    
                    if ($varient_code) {
                        $product_variant = ProductVariant::where([
                            ['product_id', $pro_id],
                            ['item_code', $varient_code]
                        ])->first();
                        if (!$product_variant || $product_variant->qty < $net_deduction) {
                            throw new \Exception("Cannot update waste. Product variant '{$product->name}' would have negative global stock.");
                        }
                    }
                    
                    if ($product->qty < $net_deduction) {
                        throw new \Exception("Cannot update waste. Product '{$product->name}' would have negative global stock.");
                    }
                }
            }

            $waste->receiver_type = $request->receiver_type;
            $waste->receiver_id = explode('-', $request->receiver_id)[0];
            $waste->receiver_name = explode('-', $request->receiver_id)[1];
            $waste->note = $request->note;
            $waste->total_price = $request->total;
            $waste->save();

            if ($waste) {
                foreach ($waste->items as $data) {
                    $product = Product::find($data->product_id);
                    $product->qty += $data->qty;
                    $product->save();

                    if ($data->varient_code) {
                        $product_variant = ProductVariant::where([
                            ['product_id', $data->product_id],
                            ['item_code', $data->varient_code]
                        ])->first();
                        if ($product_variant) {
                            $product_variant->qty += $data->qty;
                            $product_variant->save();
                        }
                    }
                }
            }

            $waste->items()->delete();
            $waste->items()->createMany($filtered_products);

            if ($waste) {
                foreach ($filtered_products as $data) {
                    $product = Product::find($data['product_id']);
                    $product->qty -= $data['qty'];
                    $product->save();

                    if (isset($data['varient_code']) && $data['varient_code']) {
                        $product_variant = ProductVariant::where([
                            ['product_id', $data['product_id']],
                            ['item_code', $data['varient_code']]
                        ])->first();
                        if ($product_variant) {
                            $product_variant->qty -= $data['qty'];
                            $product_variant->save();
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('waste.index');
    }

    public function destroy($id)
    {
        $waste = Waste::find($id);
        if ($waste) {
            foreach ($waste->items as $data) {
                $product = Product::find($data->product_id);
                $product->qty += $data->qty;
                $product->save();

                if ($data->varient_code) {
                    $product_variant = ProductVariant::where([
                        ['product_id', $data->product_id],
                        ['item_code', $data->varient_code]
                    ])->first();
                    if ($product_variant) {
                        $product_variant->qty += $data->qty;
                        $product_variant->save();
                    }
                }
            }
        }

        $waste->items()->delete();
        $waste->delete();

        return redirect()->route('waste.index');
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        if(!$lims_product_data) {
            $lims_product_variant_data = ProductVariant::where('item_code', $product_code[0])->first();
            if ($lims_product_variant_data) {
                $lims_product_data = Product::where([
                    ['id', $lims_product_variant_data->product_id],
                    ['is_active', true]
                ])->first();
            }
        }

        if (!$lims_product_data) {
            return [];
        }

        $results = [];

        if ($lims_product_data->is_variant) {
            $variants = ProductVariant::join('variants', 'product_variants.variant_id', '=', 'variants.id')
                ->where('product_variants.product_id', $lims_product_data->id)
                ->select('product_variants.*', 'variants.name as variant_name')
                ->get();

            foreach ($variants as $variant) {
                $results[] = $this->getProductSearchDetails($lims_product_data, $variant, $variant->qty);
            }
        } else {
            $results[] = $this->getProductSearchDetails($lims_product_data, null, $lims_product_data->qty);
        }

        return $results;
    }

    private function getProductSearchDetails($lims_product_data, $variant = null, $qty = 0)
    {
        $product = [];
        $product_variant_id = null;
        $price = $lims_product_data->price;
        $code = $lims_product_data->code;

        if ($variant) {
            $product[] = $lims_product_data->name . ' [' . $variant->variant_name . ']';
            $code = $variant->item_code;
            $price += $variant->additional_price;
            $product_variant_id = $variant->id;
        } else {
            $product[] = $lims_product_data->name;
        }

        $product[] = $code;
        $product[] = $price;
        if ($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $lims_product_data->tax_method;
        if ($lims_product_data->type == 'standard') {
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                ->orWhere('id', $lims_product_data->unit_id)
                ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
            foreach ($units as $unit) {
                if ($lims_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                } else {
                    $unit_name[] = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }
            $product[] = implode(",", $unit_name) . ',';
            $product[] = implode(",", $unit_operator) . ',';
            $product[] = implode(",", $unit_operation_value) . ',';
        } else {
            $product[] = 'n/a' . ',';
            $product[] = 'n/a' . ',';
            $product[] = 'n/a' . ',';
        }
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;
        $product[] = $lims_product_data->is_variant;
        $product[] = $qty; // data[15]
        return $product;
    }
}

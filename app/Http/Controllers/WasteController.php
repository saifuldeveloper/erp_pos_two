<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class WasteController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $wastes = Waste::all();
            return view('backend.waste.index', compact('wastes'));
        }
    }

    public function wastedata(Request $request)
    {

        $columns = ['date', 'receiver_type', 'receiver_id', 'total_price'];

        $query = Waste::with('items.product')
            ->select('wastes.id', 'wastes.created_at as date', 'wastes.receiver_type', 'wastes.receiver_name', 'wastes.total_price', 'wastes.status');


        if ($search = $request->input('search')['value']) {
            $query->where(function ($q) use ($search) {
                $q->where('wastes.receiver_type', 'like', "%$search%")
                    ->orWhere('products.name', 'like', "%$search%")
                    ->orWhere('products.code', 'like', "%$search%");
            });
        }


        if ($request->input('order')) {
            $orderColumn = $columns[$request->input('order')[0]['column']];
            $orderDir = $request->input('order')[0]['dir'];
            $query->orderBy($orderColumn, $orderDir);
        }


        $start = $request->input('start');
        $length = $request->input('length');
        $totalRecords = $query->count();
        $wastes = $query->offset($start)->limit($length)->get();


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
                $product_code[] =  $product->code;
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
        $waste = new Waste();
        $waste->receiver_type = $request->receiver_type;
        $waste->receiver_id = explode('-', $request->receiver_id)[0];
        $waste->receiver_name = explode('-', $request->receiver_id)[1];
        $waste->note = $request->note;
        $waste->total_price = $request->total;
        $waste->save();

        $waste->items()->createMany($request->product);

        if ($waste) {
            foreach ($request->product as $data) {
                $product = Product::find($data['product_id']);
                $product->qty -= $data['qty'];
                $product->save();
            }
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
                $product_code[] =  $product->code;
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
        $waste = Waste::find($id);
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
            }
        }

        $waste->items()->delete();
        $waste->items()->createMany($request->product);

        if ($waste) {
            foreach ($request->product as $data) {
                $product = Product::find($data['product_id']);
                $product->qty -= $data['qty'];
                $product->save();
            }
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
            }
        }

        $waste->items()->delete();
        $waste->delete();

        return redirect()->route('waste.index');
    }
}

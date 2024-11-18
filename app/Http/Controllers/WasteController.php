<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class WasteController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('sales-index'))
        {
            $products = DB::table('products')->where('qty', '>', 0)->where('is_active', true)
            ->select('id', 'name', 'code', 'price', 'qty')
            ->get();

            return view('backend.waste.create', compact('products'));
        }
    }

    public function wastedata(Request $request){

        $columns = ['date', 'receiver_type', 'receiver_id', 'product_info', 'qty', 'unit_price', 'total_price'];

        $query = DB::table('wastes')
            ->join('products', 'products.id', '=', 'wastes.product_id')
            ->select(
                'wastes.id',
                'wastes.created_at as date',
                'wastes.receiver_type',
                'wastes.receiver_name',
                'products.name as product_name',
                'products.code as product_code',
                DB::raw("CONCAT(products.name, ' (', products.code, ')') as product_info"),
                'wastes.qty',
                'wastes.unit_price',
                'wastes.total_price',
                'wastes.status'
            );


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
        $data = $request->all();

        $waste = new Waste();
        $waste->receiver_type = $data['receiver_type'];
        list($receiverId, $receiverName) = explode('-', $data['receiver_id']);
        $waste->receiver_id = $receiverId;
        $waste->receiver_name = $receiverName;
        $waste->product_id = $data['product_id'];
        $waste->qty = $data['quantity'];
        $waste->unit_price = $data['amount'];
        $waste->total_price = $data['total'];
        $waste->note = $data['note'];
        $waste->save();
        if ($waste->save()) {
            $product = Product::find($data['product_id']);
            $product->qty = $product->qty - $data['quantity'];
            $product->save();
        }

        return redirect()->route('waste.index');
    }
}

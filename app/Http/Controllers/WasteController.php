<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Waste;
use App\Repositories\Contracts\WasteRepositoryInterface;
use App\Services\WasteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class WasteController extends Controller
{
    protected WasteService $wasteService;
    protected WasteRepositoryInterface $wasteRepository;

    public function __construct(WasteService $wasteService, WasteRepositoryInterface $wasteRepository)
    {
        $this->wasteService = $wasteService;
        $this->wasteRepository = $wasteRepository;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('waste-index') || $role->hasPermissionTo('sales-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $start_date = $request->start_date ?? date('d-m-Y', strtotime('-30 days'));
            $end_date = $request->end_date ?? date('d-m-Y');
            $formatted_start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->format('Y-m-d');
            $formatted_end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->format('Y-m-d');

            $wastes = $this->wasteService->getWastesByDateRange($formatted_start_date, $formatted_end_date);

            return view('backend.waste.index', compact('wastes', 'start_date', 'end_date', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function wastedata(Request $request)
    {
        $jsonData = $this->wasteService->getWasteDataTable($request);

        return response()->json($jsonData);
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $products = $this->wasteService->getCreateProductsData();
            return view('backend.waste.create', compact('products'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getReceiverList($type)
    {
        $receivers = $this->wasteService->getReceiverList($type);

        return view('backend.waste.receiverlist', compact('receivers'));
    }

    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_info = explode("?", $request['data']);
        $customer_id = $product_info[1];

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where([
                    ['product_variants.item_code', $product_code[0]],
                    ['products.is_active', true]
                ])->first();
        }

        $product[] = $lims_product_data->name;
        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->item_code;
            $product[] = $lims_product_data->price + $lims_product_data->additional_price;
        } else {
            $product[] = $lims_product_data->code;
            $product[] = $lims_product_data->price;
        }

        if ($lims_product_data->tax_id) {
            $tax = Tax::find($lims_product_data->tax_id);
            $product[] = $tax ? $tax->rate : 0;
            $product[] = $tax ? $tax->name : 'No Tax';
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }

        $product[] = $lims_product_data->tax_method;

        $units = Unit::where("base_unit", $lims_product_data->unit_id)
            ->orWhere('id', $lims_product_data->unit_id)
            ->get();

        $unit_name = [];
        $unit_operator = [];
        $unit_operation_value = [];
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
        $product[] = $lims_product_data->id;
        $product[] = $lims_product_data->is_variant ? $lims_product_data->product_variant_id : null;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;

        return $product;
    }

    public function store(Request $request)
    {
        try {
            $this->wasteService->createWaste($request->all());
            return redirect('wastes')->with('message', 'Waste created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('not_permitted', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $formData = $this->wasteService->getEditFormData($id);
            return view('backend.waste.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function destroy($id)
    {
        $this->wasteService->deleteWaste($id);

        return redirect('wastes')->with('not_permitted', 'Waste deleted successfully');
    }
}

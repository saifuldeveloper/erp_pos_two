<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnPurchase\StoreReturnPurchaseRequest;
use App\Http\Requests\ReturnPurchase\UpdateReturnPurchaseRequest;
use App\Models\Product;
use App\Models\PurchaseProductReturn;
use App\Models\ReturnPurchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\ReturnPurchaseRepositoryInterface;
use App\Services\ReturnPurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ReturnPurchaseController extends Controller
{
    protected ReturnPurchaseService $returnPurchaseService;
    protected ReturnPurchaseRepositoryInterface $returnPurchaseRepository;

    public function __construct(ReturnPurchaseService $returnPurchaseService, ReturnPurchaseRepositoryInterface $returnPurchaseRepository)
    {
        $this->returnPurchaseService = $returnPurchaseService;
        $this->returnPurchaseRepository = $returnPurchaseRepository;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $warehouse_id = $request->input('warehouse_id', 0);

            if ($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
                $ending_date = date("Y-m-d");
            }

            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('backend.return_purchase.index', compact('starting_date', 'ending_date', 'warehouse_id', 'all_permission', 'lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function returnData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->returnPurchaseService->getReturnDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-add')) {
            $formData = $this->returnPurchaseService->getCreateFormData();
            return view('backend.return_purchase.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getSupplier($id)
    {
        return Supplier::find($id);
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.item_code', 'product_variants.additional_cost', 'product_variants.variant_id')
                ->where([
                    ['product_variants.item_code', $product_code[0]],
                    ['products.is_active', true]
                ])->first();
        }

        $product = [];
        $product[] = $lims_product_data->name;
        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->item_code;
            $product[] = $lims_product_data->cost + $lims_product_data->additional_cost;
        } else {
            $product[] = $lims_product_data->code;
            $product[] = $lims_product_data->cost;
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
            if ($lims_product_data->purchase_unit_id == $unit->id) {
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
        $product[] = $lims_product_data->is_variant ? $lims_product_data->variant_id : null;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;

        return $product;
    }

    public function productReturnData($id)
    {
        return $this->returnPurchaseRepository->getProductReturnDataByReturnId($id);
    }

    public function store(StoreReturnPurchaseRequest $request)
    {
        $this->returnPurchaseService->createReturnPurchase($request->all(), $request->file('document'));

        return redirect('return-purchase')->with('message', 'Return created successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-edit')) {
            $formData = $this->returnPurchaseService->getEditFormData($id);
            return view('backend.return_purchase.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateReturnPurchaseRequest $request, $id)
    {
        $this->returnPurchaseService->updateReturnPurchase($id, $request->all(), $request->file('document'));

        return redirect('return-purchase')->with('message', 'Return updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('returns-delete')) {
            return 'Sorry! You are not allowed to delete return purchase';
        }

        $return_ids = $request['returnIdArray'] ?? [];
        $this->returnPurchaseService->deleteMultipleReturnPurchases($return_ids);

        return 'Return deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('returns-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete return purchase');
        }

        $this->returnPurchaseService->deleteReturnPurchase($id);

        return redirect('return-purchase')->with('not_permitted', 'Data deleted successfully');
    }
}

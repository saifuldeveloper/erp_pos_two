<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\StoreTransferRequest;
use App\Http\Requests\Transfer\UpdateTransferRequest;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\Tax;
use App\Models\Transfer;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\TransferRepositoryInterface;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class TransferController extends Controller
{
    protected TransferService $transferService;
    protected TransferRepositoryInterface $transferRepository;

    public function __construct(TransferService $transferService, TransferRepositoryInterface $transferRepository)
    {
        $this->transferService = $transferService;
        $this->transferRepository = $transferRepository;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('transfers-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $from_warehouse_id = $request->input('from_warehouse_id', 0);
            $to_warehouse_id = $request->input('to_warehouse_id', 0);

            if ($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
                $ending_date = date("Y-m-d");
            }

            $lims_warehouse_list = Warehouse::select('name', 'id')->where('is_active', true)->get();
            return view('backend.transfer.index', compact('starting_date', 'ending_date', 'from_warehouse_id', 'to_warehouse_id', 'all_permission', 'lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function transferData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->transferService->getTransferDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('transfers-add')) {
            $formData = $this->transferService->getCreateFormData();
            return view('backend.transfer.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getProduct($id)
    {
        $lims_product_warehouse_data = DB::table('products')
            ->join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->whereNull('products.is_variant')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id]
            ])
            ->select('product_warehouse.qty', 'products.code', 'products.name')
            ->get();

        $lims_product_withVariant_warehouse_data = DB::table('products')
            ->join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->whereNotNull('products.is_variant')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id]
            ])
            ->select('products.name', 'product_warehouse.qty', 'product_warehouse.product_id', 'product_warehouse.variant_id')
            ->get();

        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_code[] = $product_warehouse->code;
            $product_name[] = $product_warehouse->name;
        }

        foreach ($lims_product_withVariant_warehouse_data as $product_warehouse) {
            $product_variant = ProductVariant::select('item_code')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            if ($product_variant) {
                $product_qty[] = $product_warehouse->qty;
                $product_code[] = $product_variant->item_code;
                $product_name[] = $product_warehouse->name;
            }
        }

        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;

        return $product_data;
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        [$lims_product_data, $lims_product_variant_data] = $this->transferRepository->searchProductsForTransfer($product_code[0], $request['from_warehouse_id']);

        $product = [];
        if ($lims_product_data) {
            $product[] = $lims_product_data->name;
            $product[] = $lims_product_data->code;
            $product[] = $lims_product_data->cost;

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
            $product[] = null;
            $product[] = $lims_product_data->is_batch;
            $product[] = $lims_product_data->is_imei;
        } elseif ($lims_product_variant_data) {
            $product[] = $lims_product_variant_data->name;
            $product[] = $lims_product_variant_data->item_code;
            $product[] = $lims_product_variant_data->cost + $lims_product_variant_data->additional_cost;

            if ($lims_product_variant_data->tax_id) {
                $tax = Tax::find($lims_product_variant_data->tax_id);
                $product[] = $tax ? $tax->rate : 0;
                $product[] = $tax ? $tax->name : 'No Tax';
            } else {
                $product[] = 0;
                $product[] = 'No Tax';
            }

            $product[] = $lims_product_variant_data->tax_method;

            $units = Unit::where("base_unit", $lims_product_variant_data->unit_id)
                ->orWhere('id', $lims_product_variant_data->unit_id)
                ->get();

            $unit_name = [];
            $unit_operator = [];
            $unit_operation_value = [];
            foreach ($units as $unit) {
                if ($lims_product_variant_data->purchase_unit_id == $unit->id) {
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
            $product[] = $lims_product_variant_data->id;
            $product[] = $lims_product_variant_data->variant_id;
            $product[] = $lims_product_variant_data->is_batch;
            $product[] = $lims_product_variant_data->is_imei;
        }

        return $product;
    }

    public function productTransferData($id)
    {
        return $this->transferRepository->getProductTransferDataByTransferId($id);
    }

    public function store(StoreTransferRequest $request)
    {
        $this->transferService->createTransfer($request->all(), $request->file('document'));

        return redirect('transfers')->with('message', 'Transfer created successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('transfers-edit')) {
            $formData = $this->transferService->getEditFormData($id);
            return view('backend.transfer.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateTransferRequest $request, $id)
    {
        $this->transferService->updateTransfer($id, $request->all(), $request->file('document'));

        return redirect('transfers')->with('message', 'Transfer updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('transfers-delete')) {
            return 'Sorry! You are not allowed to delete transfer';
        }

        $transfer_ids = $request['transferIdArray'] ?? [];
        $this->transferService->deleteMultipleTransfers($transfer_ids);

        return 'Transfer deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('transfers-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete transfer');
        }

        $this->transferService->deleteTransfer($id);

        return redirect('transfers')->with('not_permitted', 'Transfer deleted successfully');
    }

    public function transferByCsv()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('transfers-add')) {
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('backend.transfer.import', compact('lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}

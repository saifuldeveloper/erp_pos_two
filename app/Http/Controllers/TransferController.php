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
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    protected TransferService $transferService;
    protected TransferRepositoryInterface $transferRepository;

    public function __construct(TransferService $transferService, TransferRepositoryInterface $transferRepository)
    {
        $this->transferService = $transferService;
        $this->transferRepository = $transferRepository;
        $this->middleware('check_permission:transfers-index')->only(['index', 'transferData', 'productTransferData']);
        $this->middleware('check_permission:transfers-add')->only(['create', 'store', 'transferByCsv']);
        $this->middleware('check_permission:transfers-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:transfers-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index(Request $request)
    {
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
        return view('backend.transfer.index', compact('starting_date', 'ending_date', 'from_warehouse_id', 'to_warehouse_id', 'lims_warehouse_list'));
    }

    public function transferData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->transferService->getTransferDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $formData = $this->transferService->getCreateFormData();
        return view('backend.transfer.create', $formData);
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
            ->select('products.name', 'product_warehouse.qty', 'product_warehouse.item_code')
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
            $product_qty[] = $product_warehouse->qty;
            $product_code[] = $product_warehouse->item_code;
            $product_name[] = $product_warehouse->name;
        }

        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;
        return $product_data;
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_info = explode("|", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        if (count($product_info) > 1) {
            $product_code[0] = $product_info[0];
            $product_variant_id = $product_info[1];
        }

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        $product_variant_id = null;
        if (!$lims_product_data) {
            $product_variant_data = ProductVariant::select('id', 'product_id', 'item_code')->where('item_code', $product_code[0])->first();
            $lims_product_data = Product::find($product_variant_data->product_id);
            $product_variant_id = $product_variant_data->id;
        }

        $product[] = $lims_product_data->name;
        if ($product_variant_id) {
            $product[] = $product_variant_data->item_code;
        } else {
            $product[] = $lims_product_data->code;
        }

        $product[] = $lims_product_data->cost;

        if ($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
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
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;

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
        $formData = $this->transferService->getEditFormData($id);
        return view('backend.transfer.edit', $formData);
    }

    public function update(UpdateTransferRequest $request, $id)
    {
        $this->transferService->updateTransfer($id, $request->all(), $request->file('document'));

        return redirect('transfers')->with('message', 'Transfer updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $transfer_ids = $request['transferIdArray'] ?? [];
        $this->transferService->deleteMultipleTransfers($transfer_ids);

        return 'Transfer deleted successfully!';
    }

    public function destroy($id)
    {
        $this->transferService->deleteTransfer($id);

        return redirect('transfers')->with('not_permitted', 'Transfer deleted successfully');
    }

    public function transferByCsv()
    {
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        return view('backend.transfer.import', compact('lims_warehouse_list'));
    }
}

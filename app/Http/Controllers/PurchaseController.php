<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\CustomField;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PurchaseController extends Controller
{
    protected PurchaseService $purchaseService;
    protected PurchaseRepositoryInterface $purchaseRepository;

    public function __construct(PurchaseService $purchaseService, PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseService = $purchaseService;
        $this->purchaseRepository = $purchaseRepository;
        $this->middleware('check_permission:purchases-index')->only(['index']);
        $this->middleware('check_permission:purchases-add')->only(['create', 'store', 'purchaseByCsv']);
        $this->middleware('check_permission:purchases-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:purchases-delete')->only(['destroy', 'deleteBySelection']);
        $this->middleware('check_permission:purchase-payment-delete')->only(['deletePayment']);
    }

    public function index(Request $request)
    {
        $formData = $this->purchaseService->getIndexFormData($request);
        return view('backend.purchase.index', $formData);
    }

    public function purchaseData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->purchaseService->getPurchaseDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $formData = $this->purchaseService->getCreateFormData();
        return view('backend.purchase.create', $formData);
    }

    public function getSupplier($id)
    {
        return Supplier::find($id);
    }

    public function productPurchaseData($id)
    {
        return $this->purchaseRepository->getProductPurchaseDataByPurchaseId($id);
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $brand_id = $request->input('brand_id');

        [$lims_product_data, $lims_product_variant_data] = $this->purchaseRepository->searchProductsForPurchase($product_code[0], $brand_id);

        $product = [];
        if (count($lims_product_data) > 0) {
            foreach ($lims_product_data as $key => $product_data) {
                $product[] = $product_data->name;
                $product[] = $product_data->code;
                $product[] = $product_data->cost;

                if ($product_data->tax_id) {
                    $tax = Tax::find($product_data->tax_id);
                    $product[] = $tax ? $tax->rate : 0;
                    $product[] = $tax ? $tax->name : 'No Tax';
                } else {
                    $product[] = 0;
                    $product[] = 'No Tax';
                }

                $product[] = $product_data->tax_method;

                $units = Unit::where("base_unit", $product_data->unit_id)
                    ->orWhere('id', $product_data->unit_id)
                    ->get();

                $unit_name = [];
                $unit_operator = [];
                $unit_operation_value = [];
                foreach ($units as $unit) {
                    if ($product_data->purchase_unit_id == $unit->id) {
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
                $product[] = $product_data->id;
                $product[] = null;
                $product[] = $product_data->is_batch;
                $product[] = $product_data->is_imei;
                $product[] = $product_data->price;
            }
        } elseif (count($lims_product_variant_data) > 0) {
            foreach ($lims_product_variant_data as $key => $product_data) {
                $product[] = $product_data->name;
                $product[] = $product_data->item_code;
                $product[] = $product_data->cost + $product_data->additional_cost;

                if ($product_data->tax_id) {
                    $tax = Tax::find($product_data->tax_id);
                    $product[] = $tax ? $tax->rate : 0;
                    $product[] = $tax ? $tax->name : 'No Tax';
                } else {
                    $product[] = 0;
                    $product[] = 'No Tax';
                }

                $product[] = $product_data->tax_method;

                $units = Unit::where("base_unit", $product_data->unit_id)
                    ->orWhere('id', $product_data->unit_id)
                    ->get();

                $unit_name = [];
                $unit_operator = [];
                $unit_operation_value = [];
                foreach ($units as $unit) {
                    if ($product_data->purchase_unit_id == $unit->id) {
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
                $product[] = $product_data->id;
                $product[] = $product_data->variant_id;
                $product[] = $product_data->is_batch;
                $product[] = $product_data->is_imei;
                $product[] = $product_data->price;
            }
        }

        return $product;
    }

    public function store(StorePurchaseRequest $request)
    {
        $this->purchaseService->createPurchase($request->all(), $request->file('document'));

        return redirect('purchases')->with('message', 'Purchase created successfully');
    }

    public function edit($id)
    {
        $formData = $this->purchaseService->getEditFormData($id);
        return view('backend.purchase.edit', $formData);
    }

    public function update(UpdatePurchaseRequest $request, $id)
    {
        $this->purchaseService->updatePurchase($id, $request->all(), $request->file('document'));

        return redirect('purchases')->with('message', 'Purchase updated successfully');
    }

    public function addPayment(Request $request)
    {
        $this->purchaseService->addPayment($request->all(), $request->file('cheque_file'));

        return redirect('purchases')->with('message', 'Payment created successfully');
    }

    public function getPayment($id)
    {
        return $this->purchaseService->getPaymentsByPurchaseId($id);
    }

    public function updatePayment(Request $request)
    {
        $this->purchaseService->updatePayment($request->all(), $request->file('edit_cheque_file'));

        return redirect('purchases')->with('message', 'Payment updated successfully');
    }

    public function deletePayment(Request $request)
    {
        $this->purchaseService->deletePayment($request->id);

        return redirect('purchases')->with('not_permitted', 'Payment deleted successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $purchase_ids = $request['purchaseIdArray'] ?? [];
        $this->purchaseService->deleteMultiplePurchases($purchase_ids);

        return 'Purchase deleted successfully!';
    }

    public function destroy($id)
    {
        $this->purchaseService->deletePurchase($id);

        return redirect('purchases')->with('not_permitted', 'Purchase deleted successfully');
    }

    public function purchaseByCsv()
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();

        return view('backend.purchase.import', compact('lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list'));
    }
}

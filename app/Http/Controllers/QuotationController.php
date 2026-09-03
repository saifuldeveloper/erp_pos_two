<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\Biller;
use App\Models\Customer;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductQuotation;
use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\QuotationRepositoryInterface;
use App\Services\QuotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class QuotationController extends Controller
{
    protected QuotationService $quotationService;
    protected QuotationRepositoryInterface $quotationRepository;

    public function __construct(QuotationService $quotationService, QuotationRepositoryInterface $quotationRepository)
    {
        $this->quotationService = $quotationService;
        $this->quotationRepository = $quotationRepository;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('quotes-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            if ($request->input('warehouse_id')) {
                $warehouse_id = $request->input('warehouse_id');
            } else {
                $warehouse_id = 0;
            }

            if ($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
                $ending_date = date("Y-m-d");
            }

            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('backend.quotation.index', compact('starting_date', 'ending_date', 'warehouse_id', 'all_permission', 'lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function quotationData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->quotationService->getQuotationDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('quotes-add')) {
            $formData = $this->quotationService->getCreateFormData();
            return view('backend.quotation.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        $product_variant_id = null;
        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where([
                    ['product_variants.item_code', $product_code[0]],
                    ['products.is_active', true]
                ])->first();
            $product_variant_id = $lims_product_data->product_variant_id;
            $lims_product_data->code = $lims_product_data->item_code;
            $lims_product_data->price += $lims_product_data->additional_price;
        }

        $product = [];
        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;
        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date) {
            $product[] = $lims_product_data->promotion_price;
        } else {
            $product[] = $lims_product_data->price;
        }

        if ($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data ? $lims_tax_data->rate : 0;
            $product[] = $lims_tax_data ? $lims_tax_data->name : 'No Tax';
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }

        $product[] = $lims_product_data->tax_method;
        if ($lims_product_data->isType(ProductType::STANDARD)) {
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
        } else {
            $product[] = 'n/a,';
            $product[] = 'n/a,';
            $product[] = 'n/a,';
        }

        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;

        return $product;
    }

    public function productQuotationData($id)
    {
        return $this->quotationRepository->getProductQuotationDataByQuotationId($id);
    }

    public function store(Request $request)
    {
        $this->quotationService->createQuotation($request->all(), $request->file('document'));

        return redirect('quotations')->with('message', 'Quotation created successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('quotes-edit')) {
            $formData = $this->quotationService->getEditFormData($id);
            return view('backend.quotation.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->quotationService->updateQuotation($id, $request->all(), $request->file('document'));

        return redirect('quotations')->with('message', 'Quotation updated successfully');
    }

    public function createSale($id)
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        $lims_pos_setting_data = PosSetting::latest()->first();

        return view('backend.quotation.create_sale', compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_quotation_data', 'lims_product_quotation_data', 'lims_pos_setting_data'));
    }

    public function createPurchase($id)
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();
        $lims_product_list_without_variant = Product::ActiveStandard()->select('id', 'name', 'code')->whereNull('is_variant')->get();
        $lims_product_list_with_variant = Product::join('product_variants', 'products.id', 'product_variants.product_id')
            ->ActiveStandard()
            ->whereNotNull('is_variant')
            ->select('products.id', 'products.name', 'product_variants.item_code')
            ->orderBy('position')->get();

        return view('backend.quotation.create_purchase', compact('lims_product_list_without_variant', 'lims_product_list_with_variant', 'lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_quotation_data', 'lims_product_quotation_data'));
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('quotes-delete')) {
            return 'Sorry! You are not allowed to delete quotation';
        }

        $quotation_ids = $request['quotationIdArray'] ?? [];
        $this->quotationService->deleteMultipleQuotations($quotation_ids);

        return 'Quotation deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('quotes-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete quotation');
        }

        $this->quotationService->deleteQuotation($id);

        return redirect('quotations')->with('not_permitted', 'Quotation deleted successfully');
    }
}

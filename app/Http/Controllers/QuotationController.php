<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Http\Requests\Quotation\StoreQuotationRequest;
use App\Http\Requests\Quotation\UpdateQuotationRequest;
use App\Models\Biller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductBatch;
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

class QuotationController extends Controller
{
    protected QuotationService $quotationService;
    protected QuotationRepositoryInterface $quotationRepository;

    public function __construct(QuotationService $quotationService, QuotationRepositoryInterface $quotationRepository)
    {
        $this->quotationService = $quotationService;
        $this->quotationRepository = $quotationRepository;
        $this->middleware('check_permission:quotes-index')->only(['index', 'quotationData', 'productQuotationData']);
        $this->middleware('check_permission:quotes-add')->only(['create', 'store', 'createSale', 'createPurchase']);
        $this->middleware('check_permission:quotes-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:quotes-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index(Request $request)
    {
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
        return view('backend.quotation.index', compact('starting_date', 'ending_date', 'warehouse_id', 'lims_warehouse_list'));
    }

    public function quotationData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->quotationService->getQuotationDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $formData = $this->quotationService->getCreateFormData();
        return view('backend.quotation.create', $formData);
    }

    public function getCustomerGroup($id)
    {
        $lims_customer_data = Customer::find($id);
        if (!$lims_customer_data) {
            return 0;
        }
        $lims_customer_group_data = CustomerGroup::find($lims_customer_data->customer_group_id);
        return $lims_customer_group_data ? $lims_customer_group_data->percentage : 0;
    }

    public function getProduct($id)
    {
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_price = [];
        $product_type = [];
        $product_id = [];
        $product_list = [];
        $qty_list = [];
        $batch_no = [];
        $product_batch_id = [];
        $product_data = [];

        // retrieve data of product without variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNull('product_warehouse.variant_id')
            ->whereNull('product_warehouse.product_batch_id')
            ->select('product_warehouse.*')
            ->get();

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] = $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $batch_no[] = null;
            $product_batch_id[] = null;
        }

        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();

        $lims_product_with_batch_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNull('product_warehouse.variant_id')
            ->whereNotNull('product_warehouse.product_batch_id')
            ->select('product_warehouse.*')
            ->groupBy('product_warehouse.product_id')
            ->get();

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect();

        foreach ($lims_product_with_batch_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] = $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $product_batch_data = ProductBatch::select('id', 'batch_no')->find($product_warehouse->product_batch_id);
            $batch_no[] = $product_batch_data ? $product_batch_data->batch_no : null;
            $product_batch_id[] = $product_batch_data ? $product_batch_data->id : null;
        }

        // retrieve data of product with variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNotNull('product_warehouse.variant_id')
            ->select('product_warehouse.*')
            ->get();

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            if ($lims_product_variant_data) {
                $product_code[] = $lims_product_variant_data->item_code;
                $product_name[] = $lims_product_data->name;
                $product_type[] = $lims_product_data->type;
                $product_id[] = $lims_product_data->id;
                $product_list[] = null;
                $qty_list[] = null;
                $batch_no[] = null;
                $product_batch_id[] = null;
            }
        }

        // retrieve product data of digital and combo
        $lims_product_data = Product::whereNotIn('type', [ProductType::STANDARD->value])->where('is_active', true)->get();
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
        }

        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id];
        return $product_data;
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
        $product_variant_data = null;
        if (!$lims_product_data) {
            $product_variant_data = ProductVariant::select('id', 'product_id', 'item_code', 'additional_price')->where('item_code', $product_code[0])->first();
            if ($product_variant_data) {
                $lims_product_data = Product::find($product_variant_data->product_id);
                $product_variant_id = $product_variant_data->id;
            }
        }

        if (!$lims_product_data) {
            return [];
        }

        $product = [];
        $product[] = $lims_product_data->name;
        if ($product_variant_id && $product_variant_data) {
            $product[] = $product_variant_data->item_code;
        } else {
            $product[] = $lims_product_data->code;
        }

        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date && $todayDate >= $lims_product_data->starting_date) {
            $product[] = $lims_product_data->promotion_price;
        } else {
            $product_price = $lims_product_data->price;
            if ($product_variant_id && $product_variant_data && isset($product_variant_data->additional_price)) {
                $product_price += $product_variant_data->additional_price;
            }
            $product[] = $product_price;
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

    public function store(StoreQuotationRequest $request)
    {
        $this->quotationService->createQuotation($request->all(), $request->file('document'));

        return redirect('quotations')->with('message', 'Quotation created successfully');
    }

    public function edit($id)
    {
        $formData = $this->quotationService->getEditFormData($id);
        return view('backend.quotation.edit', $formData);
    }

    public function update(UpdateQuotationRequest $request, $id)
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
        $lims_product_quotation_data = ProductQuotation::with(['product.productVariants', 'unit', 'variant', 'productBatch'])->where('quotation_id', $id)->get();
        $lims_pos_setting_data = PosSetting::latest()->first();
        $all_units = Unit::all();
        $all_taxes = $lims_tax_list;

        return view('backend.quotation.create_sale', compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_quotation_data', 'lims_product_quotation_data', 'lims_pos_setting_data', 'all_units', 'all_taxes'));
    }

    public function createPurchase($id)
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::with(['product.productVariants', 'unit', 'variant', 'productBatch'])->where('quotation_id', $id)->get();
        $lims_product_list_without_variant = Product::ActiveStandard()->select('id', 'name', 'code')->whereNull('is_variant')->get();
        $lims_product_list_with_variant = Product::join('product_variants', 'products.id', 'product_variants.product_id')
            ->ActiveStandard()
            ->whereNotNull('is_variant')
            ->select('products.id', 'products.name', 'product_variants.item_code')
            ->orderBy('position')->get();
        $all_units = Unit::all();
        $all_taxes = $lims_tax_list;

        return view('backend.quotation.create_purchase', compact('lims_product_list_without_variant', 'lims_product_list_with_variant', 'lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_quotation_data', 'lims_product_quotation_data', 'all_units', 'all_taxes'));
    }

    public function deleteBySelection(Request $request)
    {
        $quotation_ids = $request['quotationIdArray'] ?? [];
        $this->quotationService->deleteMultipleQuotations($quotation_ids);

        return 'Quotation deleted successfully!';
    }

    public function destroy($id)
    {
        $this->quotationService->deleteQuotation($id);

        return redirect('quotations')->with('not_permitted', 'Quotation deleted successfully');
    }
}

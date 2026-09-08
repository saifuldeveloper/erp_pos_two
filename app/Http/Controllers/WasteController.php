<?php

namespace App\Http\Controllers;

use App\Http\Requests\Waste\StoreWasteRequest;
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

class WasteController extends Controller
{
    protected WasteService $wasteService;
    protected WasteRepositoryInterface $wasteRepository;

    public function __construct(WasteService $wasteService, WasteRepositoryInterface $wasteRepository)
    {
        $this->wasteService = $wasteService;
        $this->wasteRepository = $wasteRepository;
        $this->middleware('check_permission:waste-index|sales-index|waste')->only(['index', 'wastedata']);
        $this->middleware('check_permission:waste-add|sales-index|waste')->only(['create', 'store']);
        $this->middleware('check_permission:waste-edit|sales-index|waste')->only(['edit', 'update']);
        $this->middleware('check_permission:waste-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date ?? date('d-m-Y', strtotime('-30 days'));
        $end_date = $request->end_date ?? date('d-m-Y');
        $formatted_start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->format('Y-m-d');
        $formatted_end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->format('Y-m-d');

        $wastes = $this->wasteService->getWastesByDateRange($formatted_start_date, $formatted_end_date);

        return view('backend.waste.index', compact('wastes', 'start_date', 'end_date'));
    }

    public function wastedata(Request $request)
    {
        $jsonData = $this->wasteService->getWasteDataTable($request);

        return response()->json($jsonData);
    }

    public function create()
    {
        $products = $this->wasteService->getCreateProductsData();
        return view('backend.waste.create', compact('products'));
    }

    public function getReceiverList($type)
    {
        $receivers = $this->wasteService->getReceiverList($type);

        return view('backend.waste.receiverlist', compact('receivers'));
    }

    public function limsProductSearch(Request $request)
    {
        $data = $request['data'] ?? '';
        if (strpos($data, '|') !== false) {
            $product_code = explode('|', $data);
        } elseif (strpos($data, '(') !== false) {
            $product_code = explode('(', $data);
        } else {
            $product_code = [$data];
        }
        $code = trim($product_code[0]);

        $lims_product_data = Product::where([
            ['code', $code],
            ['is_active', true]
        ])->get();

        $lims_product_variant_data = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->where([
                ['product_variants.item_code', $code],
                ['products.is_active', true]
            ])
            ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price', 'product_variants.variant_id')
            ->get();

        $all_products = [];

        if (count($lims_product_data) > 0) {
            foreach ($lims_product_data as $product_data) {
                if ($product_data->is_variant) {
                    $variants = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
                        ->where('products.id', $product_data->id)
                        ->where('products.is_active', true)
                        ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price', 'product_variants.variant_id')
                        ->orderBy('product_variants.position')
                        ->get();

                    if (count($variants) > 0) {
                        foreach ($variants as $variant_data) {
                            $all_products[] = $this->formatProductWasteRow($variant_data, true);
                        }
                    } else {
                        $all_products[] = $this->formatProductWasteRow($product_data, false);
                    }
                } else {
                    $all_products[] = $this->formatProductWasteRow($product_data, false);
                }
            }
        } elseif (count($lims_product_variant_data) > 0) {
            foreach ($lims_product_variant_data as $variant_data) {
                $all_products[] = $this->formatProductWasteRow($variant_data, true);
            }
        }

        return response()->json($all_products);
    }

    protected function formatProductWasteRow($product_data, bool $is_variant): array
    {
        $product = [];
        $product[] = $product_data->name;
        $product[] = $is_variant ? $product_data->item_code : $product_data->code;
        $product[] = $is_variant ? ($product_data->price + ($product_data->additional_price ?? 0)) : $product_data->price;

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
            if ($product_data->sale_unit_id == $unit->id) {
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
        $product[] = $is_variant ? ($product_data->variant_id ?? $product_data->product_variant_id) : null;
        $product[] = $product_data->is_batch;
        $product[] = $product_data->is_imei;
        $product[] = $product_data->cost;
        $product[] = $is_variant ? 1 : 0;

        return $product;
    }

    public function store(StoreWasteRequest $request)
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
        $formData = $this->wasteService->getEditFormData($id);
        return view('backend.waste.edit', $formData);
    }

    public function destroy($id)
    {
        $this->wasteService->deleteWaste($id);

        return redirect('wastes')->with('not_permitted', 'Waste deleted successfully');
    }
}

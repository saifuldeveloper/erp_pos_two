<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Mail\PaymentDetails;
use App\Mail\SaleDetails;
use App\Models\Account;
use App\Models\Biller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomField;
use App\Models\Expense;
use App\Models\GiftCard;
use App\Models\MailSetting;
use App\Models\Payment;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductPurchase;
use App\Models\ProductVariant;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\Purchase;
use App\Models\Returns;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Table;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Enums\ProductType;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Services\SaleService;
use App\Traits\MailInfo;
use App\Traits\TenantInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use NumberToWords\NumberToWords;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class SaleController extends Controller
{
    use TenantInfo;
    use MailInfo;

    protected SaleService $saleService;
    protected SaleRepositoryInterface $saleRepository;

    /**
     * SaleController constructor.
     *
     * @param SaleService $saleService
     * @param SaleRepositoryInterface $saleRepository
     */
    public function __construct(SaleService $saleService, SaleRepositoryInterface $saleRepository)
    {
        $this->saleService = $saleService;
        $this->saleRepository = $saleRepository;

        $this->middleware('check_permission:sales-index')->only(['index']);
        $this->middleware('check_permission:sales-add')->only(['create', 'store', 'posSale', 'saleByCsv', 'importSale']);
        $this->middleware('check_permission:sales-edit')->only(['edit', 'update', 'createSale']);
        $this->middleware('check_permission:sales-delete')->only(['destroy', 'deleteBySelection']);
        $this->middleware('check_permission:sale-payment-delete')->only(['deletePayment']);
    }

    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $formData = $this->saleService->getIndexFormData($request);
        return view('backend.sale.index', $formData);
    }

    /**
     * DataTables server-side processor for sales.
     */
    public function saleData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->saleService->getSaleDataTable($request, $allPermissions);
        return response()->json($jsonData);
    }

    /**
     * Show create sale form.
     */
    public function create()
    {
        $formData = $this->saleService->getCreateFormData();
        return view('backend.sale.create', $formData);
    }

    /**
     * Store a new sale.
     */
    public function store(StoreSaleRequest $request)
    {
        $result = $this->saleService->store($request->all());
        $sale = $result['sale'];
        $message = $result['message'];

        if ($sale->sale_status == '1') {
            return redirect('sales/gen_invoice/' . $sale->id)->with('message', $message);
        } elseif ($request->pos) {
            return redirect('pos')->with('message', $message);
        } else {
            return redirect('sales')->with('message', $message);
        }
    }

    /**
     * Show edit sale form.
     */
    public function edit($id)
    {
        $formData = $this->saleService->getEditFormData($id);
        return view('backend.sale.edit', $formData);
    }

    /**
     * Update an existing sale.
     */
    public function update(UpdateSaleRequest $request, $id)
    {
        $result = $this->saleService->updateSale($id, $request->all(), $request->file('document'));
        return redirect('sales')->with('message', $result['message']);
    }

    /**
     * Delete a single sale.
     */
    public function destroy($id)
    {
        $this->saleService->deleteSale($id);
        return redirect('sales')->with('not_permitted', 'Sale deleted successfully');
    }

    /**
     * Delete multiple sales by selection.
     */
    public function deleteBySelection(Request $request)
    {
        $sale_ids = $request->input('saleIdArray', []);
        $this->saleService->deleteMultipleSales($sale_ids);
        return 'Sale deleted successfully!';
    }

    /**
     * Display the POS sale screen.
     */
    public function posSale()
    {
        $formData = $this->saleService->getPosFormData();
        return view('backend.sale.pos', $formData);
    }

    /**
     * Get product details for a sale modal.
     */
    public function productSaleData($id)
    {
        return $this->saleRepository->getProductSaleDataBySaleId($id);
    }

    /**
     * Add a payment to a sale.
     */
    public function addPayment(Request $request)
    {
        $result = $this->saleService->addPayment($request->all(), $request->file('cheque_file'));
        return redirect('sales')->with('message', $result['message']);
    }

    /**
     * Get payments for a sale modal.
     */
    public function getPayment($id)
    {
        return $this->saleRepository->getPaymentsBySaleId($id);
    }

    /**
     * Update an existing payment.
     */
    public function updatePayment(Request $request)
    {
        $result = $this->saleService->updatePayment($request->all(), $request->file('edit_cheque_file'));
        return redirect('sales')->with('message', $result['message']);
    }

    /**
     * Delete a payment.
     */
    public function deletePayment(Request $request)
    {
        $this->saleService->deletePayment($request->input('id'));
        return redirect('sales')->with('not_permitted', 'Payment deleted successfully');
    }

    /**
     * Show CSV import view.
     */
    public function saleByCsv()
    {
        return view('backend.sale.import');
    }

    /**
     * Import sales from CSV file.
     */
    public function importSale(Request $request)
    {
        try {
            $result = $this->saleService->importSaleFromCsv($request->file('file'), $request->all(), $request->file('document'));
            return redirect('sales')->with('message', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Create sale from draft / quotation.
     */
    public function createSale($id)
    {
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_sale_data = Sale::with('coupon')->find($id);
        $lims_product_sale_data = Product_Sale::with(['product.productVariants', 'productBatch'])->where('sale_id', $id)->get();
        $lims_product_list = Product::where([
            ['featured', 1],
            ['is_active', true]
        ])->get();

        foreach ($lims_product_list as $product) {
            $images = explode(",", $product->image);
            $product->base_image = !empty($images[0]) ? $images[0] : 'zummXD2dvAtI.png';
        }

        $product_number = count($lims_product_list);
        $lims_pos_setting_data = PosSetting::latest()->first();
        $lims_brand_list = Brand::where('is_active', true)->get();
        $lims_category_list = Category::where('is_active', 1)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
        $lims_coupon_list = Coupon::where('is_active', true)->get();
        $currency_list = Currency::where('is_active', true)->get();
        $all_units = Unit::where('is_active', true)->get();
        $all_taxes = $lims_tax_list;

        return view('backend.sale.create_sale', compact(
            'currency_list',
            'lims_biller_list',
            'lims_customer_list',
            'lims_warehouse_list',
            'lims_tax_list',
            'lims_sale_data',
            'lims_product_sale_data',
            'lims_pos_setting_data',
            'lims_brand_list',
            'lims_category_list',
            'lims_coupon_list',
            'lims_product_list',
            'product_number',
            'lims_customer_group_all',
            'lims_reward_point_setting_data',
            'all_units',
            'all_taxes'
        ));
    }

    /**
     * Get products by warehouse ID.
     */
    public function getProduct($id)
    {
        $warehouse_id = (int)$id;

        $baseQuery = function () {
            $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id');
            if (config('without_stock') == 'no') {
                return $query->where([
                    ['products.is_active', true],
                    ['product_warehouse.qty', '>', 0]
                ]);
            }
            return $query->where('products.is_active', true);
        };

        // 1. Standard products without variant & without batch
        $lims_product_warehouse_data = $baseQuery()
            ->whereNull('product_warehouse.variant_id')
            ->whereNull('product_warehouse.product_batch_id')
            ->selectRaw('products.id as product_id, products.code, products.name, products.type, products.product_list, products.qty_list, products.is_embeded, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . $warehouse_id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('products.id', 'products.code', 'products.name', 'products.type', 'products.product_list', 'products.qty_list', 'products.is_embeded')
            ->get();

        // 2. Products with batch
        $lims_product_with_batch_warehouse_data = $baseQuery()
            ->leftJoin('product_batches', 'product_warehouse.product_batch_id', '=', 'product_batches.id')
            ->whereNull('product_warehouse.variant_id')
            ->whereNotNull('product_warehouse.product_batch_id')
            ->selectRaw('products.id as product_id, products.code, products.name, products.type, products.product_list, products.qty_list, products.is_embeded, product_warehouse.product_batch_id, product_batches.batch_no, product_batches.expired_date, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . $warehouse_id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('products.id', 'products.code', 'products.name', 'products.type', 'products.product_list', 'products.qty_list', 'products.is_embeded', 'product_warehouse.product_batch_id', 'product_batches.batch_no', 'product_batches.expired_date')
            ->get();

        // 3. Products with variant
        $lims_product_with_variant_warehouse_data = $baseQuery()
            ->leftJoin('product_variants', function ($join) {
                $join->on('product_warehouse.product_id', '=', 'product_variants.product_id')
                    ->on('product_warehouse.variant_id', '=', 'product_variants.variant_id');
            })
            ->whereNotNull('product_warehouse.variant_id')
            ->selectRaw('products.id as product_id, products.code, products.name, products.type, products.product_list, products.qty_list, products.is_embeded, product_warehouse.variant_id, product_variants.item_code, product_variants.additional_price, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . $warehouse_id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('products.id', 'products.code', 'products.name', 'products.type', 'products.product_list', 'products.qty_list', 'products.is_embeded', 'product_warehouse.variant_id', 'product_variants.item_code', 'product_variants.additional_price')
            ->get();

        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_type = [];
        $product_id = [];
        $product_list = [];
        $qty_list = [];
        $product_price = [];
        $batch_no = [];
        $product_batch_id = [];
        $expired_date = [];
        $is_embeded = [];

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $product_code[] = $product_warehouse->code;
            $product_name[] = htmlspecialchars($product_warehouse->name);
            $product_type[] = $product_warehouse->type;
            $product_id[] = $product_warehouse->product_id;
            $product_list[] = $product_warehouse->product_list;
            $qty_list[] = $product_warehouse->qty_list;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            $is_embeded[] = $product_warehouse->is_embeded;
        }

        foreach ($lims_product_with_batch_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $product_code[] = $product_warehouse->code;
            $product_name[] = htmlspecialchars($product_warehouse->name);
            $product_type[] = $product_warehouse->type;
            $product_id[] = $product_warehouse->product_id;
            $product_list[] = $product_warehouse->product_list;
            $qty_list[] = $product_warehouse->qty_list;
            $batch_no[] = $product_warehouse->batch_no;
            $product_batch_id[] = $product_warehouse->product_batch_id;
            $expired_date[] = $product_warehouse->expired_date;
            $is_embeded[] = $product_warehouse->is_embeded;
        }

        foreach ($lims_product_with_variant_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_code[] = $product_warehouse->item_code ?: $product_warehouse->code;
            $product_name[] = htmlspecialchars($product_warehouse->name);
            $product_type[] = $product_warehouse->type;
            $product_id[] = $product_warehouse->product_id;
            $product_list[] = $product_warehouse->product_list;
            $qty_list[] = $product_warehouse->qty_list;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            $is_embeded[] = $product_warehouse->is_embeded;
            $product_price[] = $product_warehouse->price + ($product_warehouse->additional_price ?? 0);
        }

        $lims_product_data = Product::whereNotIn('type', [ProductType::STANDARD->value])->where('is_active', true)->select('id', 'name', 'code', 'type', 'qty', 'price', 'product_list', 'qty_list')->get();
        foreach ($lims_product_data as $product) {
            $product_qty[] = $product->qty;
            $product_price[] = $product->price;
            $product_code[] = $product->code;
            $product_name[] = htmlspecialchars($product->name);
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            $is_embeded[] = 0;
        }

        return [
            $product_code,
            $product_name,
            $product_qty,
            $product_type,
            $product_id,
            $product_list,
            $qty_list,
            $product_price,
            $batch_no,
            $product_batch_id,
            $expired_date,
            $is_embeded
        ];
    }

    /**
     * Filter products by category and brand for POS.
     */
    public function getProductByFilter($category_id, $brand_id)
    {
        $data = [];
        $warehouse_id = request()->input('warehouse_id');
        if (!$warehouse_id || $warehouse_id == 'undefined') {
            $lims_pos_setting_data = DB::table('pos_setting')->latest()->first();
            $warehouse_id = $lims_pos_setting_data->warehouse_id ?? 0;
        }

        if (($category_id != 0) && ($brand_id != 0)) {
            $lims_product_list = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->where([
                    ['products.is_active', true],
                    ['products.category_id', $category_id],
                    ['brand_id', $brand_id]
                ])->orWhere([
                    ['categories.parent_id', $category_id],
                    ['products.is_active', true],
                    ['brand_id', $brand_id]
                ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
                ->with(['variant' => function ($q) {
                    $q->orderBy('product_variants.position');
                }])->get();
        } elseif (($category_id != 0) && ($brand_id == 0)) {
            $lims_product_list = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->where([
                    ['products.is_active', true],
                    ['products.category_id', $category_id],
                ])->orWhere([
                    ['categories.parent_id', $category_id],
                    ['products.is_active', true]
                ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
                ->with(['variant' => function ($q) {
                    $q->orderBy('product_variants.position');
                }])->get();
        } elseif (($category_id == 0) && ($brand_id != 0)) {
            $lims_product_list = Product::where([
                ['brand_id', $brand_id],
                ['is_active', true]
            ])
                ->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
                ->with(['variant' => function ($q) {
                    $q->orderBy('product_variants.position');
                }])->get();
        } else {
            $lims_product_list = Product::where('is_active', true)
                ->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
                ->with(['variant' => function ($q) {
                    $q->orderBy('product_variants.position');
                }])->get();
        }

        $product_ids = $lims_product_list->pluck('id')->toArray();
        $warehouse_stocks = DB::table('product_warehouse')
            ->whereIn('product_id', $product_ids)
            ->select('product_id', 'variant_id', DB::raw('SUM(qty) as qty'))
            ->groupBy('product_id', 'variant_id')
            ->get();
        $stock_map = [];
        foreach ($warehouse_stocks as $st) {
            $key = $st->product_id . '_' . ($st->variant_id ?? 0);
            $stock_map[$key] = $st->qty;
        }

        $index = 0;
        foreach ($lims_product_list as $product) {
            if ($product->is_variant) {
                foreach ($product->variant as $variant) {
                    $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
                    $data['code'][$index] = $variant->pivot['item_code'];
                    $images = explode(",", $product->image);
                    $data['image'][$index] = $images[0];
                    $data['qty'][$index] = $stock_map[$product->id . '_' . $variant->id] ?? 0;
                    $index++;
                }
            } else {
                $data['name'][$index] = $product->name;
                $data['code'][$index] = $product->code;
                $images = explode(",", $product->image);
                $data['image'][$index] = $images[0];
                $data['qty'][$index] = $stock_map[$product->id . '_0'] ?? 0;
                $index++;
            }
        }
        return $data;
    }

    /**
     * Get featured products for POS.
     */
    public function getFeatured()
    {
        $data = [];
        $warehouse_id = request()->input('warehouse_id');
        if (!$warehouse_id || $warehouse_id == 'undefined') {
            $lims_pos_setting_data = DB::table('pos_setting')->latest()->first();
            $warehouse_id = $lims_pos_setting_data->warehouse_id ?? 0;
        }

        $lims_product_list = Product::where([
            ['is_active', true],
            ['featured', true]
        ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
            ->with(['variant' => function ($q) {
                $q->orderBy('product_variants.position');
            }])->get();

        $product_ids = $lims_product_list->pluck('id')->toArray();
        $warehouse_stocks = DB::table('product_warehouse')
            ->whereIn('product_id', $product_ids)
            ->select('product_id', 'variant_id', DB::raw('SUM(qty) as qty'))
            ->groupBy('product_id', 'variant_id')
            ->get();
        $stock_map = [];
        foreach ($warehouse_stocks as $st) {
            $key = $st->product_id . '_' . ($st->variant_id ?? 0);
            $stock_map[$key] = $st->qty;
        }

        $index = 0;
        foreach ($lims_product_list as $product) {
            if ($product->is_variant) {
                foreach ($product->variant as $variant) {
                    $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
                    $data['code'][$index] = $variant->pivot['item_code'];
                    $images = explode(",", $product->image);
                    $data['image'][$index] = $images[0];
                    $data['qty'][$index] = $stock_map[$product->id . '_' . $variant->id] ?? 0;
                    $index++;
                }
            } else {
                $data['name'][$index] = $product->name;
                $data['code'][$index] = $product->code;
                $images = explode(",", $product->image);
                $data['image'][$index] = $images[0];
                $data['qty'][$index] = $stock_map[$product->id . '_0'] ?? 0;
                $index++;
            }
        }
        return $data;
    }

    /**
     * Get customer group discount percent.
     */
    public function getCustomerGroup($id)
    {
        $lims_customer_group_data = CustomerGroup::find($id);
        return $lims_customer_group_data ? $lims_customer_group_data->percentage : 0;
    }

    /**
     * Search product for sales/POS screen.
     */
    public function limsProductSearch(Request $request)
    {
        $product_info = explode("?", $request['data']);
        $customer_id = $product_info[1] ?? null;
        $qty = $product_info[2] ?? null;
        $product_code = explode("(", $product_info[0]);
        $product_code[0] = rtrim($product_code[0], " ");
        $parent_variant_id = null;

        $search_code = trim($product_code[0]);
        $clean_code = preg_replace('/\s*([\/\-])\s*/', '$1', $search_code);
        $normalized_code = str_replace(' ', '-', $clean_code);
        $clean_no_space = str_replace(' ', '', $clean_code);

        $lims_product_data = Product::where(function ($q) use ($search_code, $clean_code, $normalized_code, $clean_no_space) {
            $q->where('code', $search_code)
                ->orWhere('code', $clean_code)
                ->orWhere('code', $normalized_code)
                ->orWhere('code', $clean_no_space);
        })->where('is_active', true)->first();

        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where('products.is_active', true)
                ->where(function ($q) use ($search_code, $clean_code, $normalized_code, $clean_no_space) {
                    $q->where('product_variants.item_code', $search_code)
                        ->orWhere('product_variants.item_code', $clean_code)
                        ->orWhere('product_variants.item_code', $normalized_code)
                        ->orWhere('product_variants.item_code', $clean_no_space);
                })->first();

            if ($lims_product_data) {
                $parent_variant_id = $lims_product_data->variant_id;
            }
        }

        if (!$lims_product_data) {
            return 'nokey';
        }

        if ($lims_product_data && $lims_product_data->is_variant && !$parent_variant_id) {
            $pv = DB::table('product_variants')
                ->where('product_id', $lims_product_data->id)
                ->where(function ($q) use ($search_code, $clean_code, $normalized_code, $clean_no_space) {
                    $q->where('item_code', $search_code)
                        ->orWhere('item_code', $clean_code)
                        ->orWhere('item_code', $normalized_code)
                        ->orWhere('item_code', $clean_no_space);
                })
                ->first();
            if ($pv) {
                $parent_variant_id = $pv->variant_id;
                $lims_product_data->item_code = $pv->item_code;
                $lims_product_data->additional_price = $pv->additional_price;
            } else {
                // Main code was entered for a variant product -> return variant suggestions list
                $warehouse_id = $request->warehouse_id ?? $request->input('warehouse_id');
                $variants = DB::table('product_variants')
                    ->leftJoin('variants', 'product_variants.variant_id', '=', 'variants.id')
                    ->leftJoin('product_warehouse', function ($join) {
                        $join->on('product_variants.product_id', '=', 'product_warehouse.product_id')
                            ->on('product_variants.variant_id', '=', 'product_warehouse.variant_id');
                    })
                    ->where('product_variants.product_id', $lims_product_data->id)
                    ->select(
                        'product_variants.id as product_variant_id',
                        'product_variants.variant_id',
                        'product_variants.item_code',
                        'product_variants.additional_price',
                        'variants.name as variant_name',
                        DB::raw('COALESCE(SUM(product_warehouse.qty), 0) as stock')
                    )
                    ->groupBy(
                        'product_variants.id',
                        'product_variants.variant_id',
                        'product_variants.item_code',
                        'product_variants.additional_price',
                        'variants.name',
                        'product_variants.position'
                    )
                    ->orderBy('product_variants.position')
                    ->get();

                return response()->json([
                    'is_variant_list' => true,
                    'product_id' => $lims_product_data->id,
                    'product_name' => $lims_product_data->name,
                    'product_code' => $lims_product_data->code,
                    'base_price' => $lims_product_data->price,
                    'variants' => $variants
                ]);
            }
        }

        $product[] = $lims_product_data->name;
        if ($parent_variant_id) {
            $product[] = $lims_product_data->item_code;
        } else {
            $product[] = $lims_product_data->code;
        }

        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->price + ($lims_product_data->additional_price ?? 0);
        } else {
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
        $product[] = $parent_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;
        $product[] = $lims_product_data->is_variant;
        $product[] = $qty ?: 1;

        $pwQuery = Product_Warehouse::where('product_id', $lims_product_data->id);
        if ($parent_variant_id) {
            $pwQuery->where('variant_id', $parent_variant_id);
        }
        $stock = (float) $pwQuery->sum('qty');
        if ($stock == 0 && !$lims_product_data->is_variant) {
            $stock = (float) ($lims_product_data->qty ?? 0);
        }

        $product[] = $lims_product_data->cost;
        $product[] = $lims_product_data->product_list;
        $product[] = $stock;
        $product[] = $lims_product_data->type;

        return $product;
    }

    /**
     * Check discount for product and customer.
     */
    public function checkDiscount(Request $request)
    {
        $qty = $request->input('qty');
        $customer_id = $request->input('customer_id');
        $lims_product_data = Product::select('id', 'price', 'promotion', 'promotion_price', 'last_date')->find($request->input('product_id'));
        $todayDate = date('Y-m-d');
        $all_discount = DB::table('discount_plan_customers')
            ->join('discount_plans', 'discount_plans.id', '=', 'discount_plan_customers.discount_plan_id')
            ->join('discount_plan_discounts', 'discount_plans.id', '=', 'discount_plan_discounts.discount_plan_id')
            ->join('discounts', 'discounts.id', '=', 'discount_plan_discounts.discount_id')
            ->where([
                ['discount_plans.is_active', true],
                ['discounts.is_active', true],
                ['discount_plan_customers.customer_id', $customer_id]
            ])
            ->select('discounts.*')
            ->get();

        $no_discount = 1;
        $price = $lims_product_data->price;

        foreach ($all_discount as $discount) {
            $product_list = explode(",", $discount->product_list);
            $days = explode(",", $discount->days);

            if (($discount->applicable_for == 'All' || in_array($lims_product_data->id, $product_list))
                && ($todayDate >= $discount->valid_from && $todayDate <= $discount->valid_till && in_array(date('D'), $days) && $qty >= $discount->minimum_qty && $qty <= $discount->maximum_qty)
            ) {
                if ($discount->type == 'flat') {
                    $price = $lims_product_data->price - $discount->value;
                } elseif ($discount->type == 'percentage') {
                    $price = $lims_product_data->price - ($lims_product_data->price * ($discount->value / 100));
                }
                $no_discount = 0;
                break;
            }
        }

        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date && $no_discount) {
            $price = $lims_product_data->promotion_price;
        } elseif ($no_discount) {
            $price = $lims_product_data->price;
        }

        return [$price, $lims_product_data->promotion];
    }

    /**
     * Get active gift cards.
     */
    public function getGiftCard()
    {
        return GiftCard::where('is_active', true)->whereDate('expired_date', '>=', date("Y-m-d"))->get(['id', 'card_no', 'amount', 'expense']);
    }

    /**
     * Redirect to last invoice.
     */
    public function printLastReciept()
    {
        $sale = Sale::where('sale_status', 1)->latest()->first();
        return redirect()->route('sale.invoice', $sale->id);
    }

    /**
     * Generate invoice and ZATCA QR code.
     */
    public function genInvoice($id)
    {
        $lims_sale_data = Sale::find($id);
        $lims_product_sale_data = Product_Sale::with(['product', 'unit', 'variant', 'productBatch'])->where('sale_id', $id)->get();

        $lims_biller_data = cache()->has('biller_list')
            ? cache()->get('biller_list')->find($lims_sale_data->biller_id)
            : Biller::find($lims_sale_data->biller_id);

        $lims_warehouse_data = cache()->has('warehouse_list')
            ? cache()->get('warehouse_list')->find($lims_sale_data->warehouse_id)
            : Warehouse::find($lims_sale_data->warehouse_id);

        $lims_customer_data = cache()->has('customer_list')
            ? cache()->get('customer_list')->find($lims_sale_data->customer_id)
            : Customer::find($lims_sale_data->customer_id);

        $lims_payment_data = Payment::where('sale_id', $id)->get();

        $numberInWords = '';
        try {
            $numberToWords = new NumberToWords();
            $locale = in_array(app()->getLocale(), ['en', 'fr', 'de', 'es', 'pt', 'it', 'ru']) ? app()->getLocale() : 'en';
            $numberTransformer = $numberToWords->getNumberTransformer($locale);
            $numberInWords = $numberTransformer->toWords($lims_sale_data->grand_total);
        } catch (\Throwable $e) {
            $numberInWords = (string) $lims_sale_data->grand_total;
        }

        $lims_pos_setting_data = PosSetting::latest()->first();
        $currency_code = Currency::where('id', $lims_sale_data->currency_id)->value('code') ?? 'BDT';

        $paying_methods = Payment::where('sale_id', $id)->pluck('paying_method')->toArray();
        $paid_by_info = implode(', ', $paying_methods);

        $qrText = $lims_sale_data->reference_no;
        if (class_exists('Salla\ZATCA\GenerateQrCode') && $lims_biller_data) {
            try {
                $qrText = GenerateQrCode::fromArray([
                    new Seller($lims_biller_data->name),
                    new TaxNumber($lims_biller_data->vat_number ?? '0'),
                    new InvoiceDate(date('c', strtotime($lims_sale_data->created_at))),
                    new InvoiceTotalAmount($lims_sale_data->grand_total),
                    new InvoiceTaxAmount($lims_sale_data->total_tax ?? 0)
                ])->toBase64();
            } catch (\Exception $e) {
                $qrText = $lims_sale_data->reference_no;
            }
        }

        $sale_custom_fields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_invoice', true]
        ])->pluck('name');
        $customer_custom_fields = CustomField::where([
            ['belongs_to', 'customer'],
            ['is_invoice', true]
        ])->pluck('name');
        $product_custom_fields = CustomField::where([
            ['belongs_to', 'product'],
            ['is_invoice', true]
        ])->pluck('name');

        if ($lims_pos_setting_data && $lims_pos_setting_data->invoice_option == 'A4') {
            return view('backend.sale.a4_invoice', compact('lims_sale_data', 'currency_code', 'lims_product_sale_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'numberInWords', 'paid_by_info', 'sale_custom_fields', 'customer_custom_fields', 'product_custom_fields', 'qrText'));
        } else {
            return view('backend.sale.invoice', compact('lims_sale_data', 'currency_code', 'lims_product_sale_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'numberInWords', 'sale_custom_fields', 'customer_custom_fields', 'product_custom_fields', 'qrText'));
        }
    }

    /**
     * Send email with sale details.
     */
    public function sendMail(Request $request)
    {
        $data = $request->all();
        $lims_sale_data = Sale::find($data['sale_id']);
        $lims_product_sale_data = Product_Sale::where('sale_id', $data['sale_id'])->get();
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        $mail_setting = MailSetting::latest()->first();

        if (!$mail_setting) {
            return $this->setErrorMessage('Please Setup Your Mail Credentials First.');
        }

        if (!$lims_customer_data->email) {
            return redirect()->back()->with('not_permitted', 'Customer doesnt have email!');
        }

        $mail_data['email'] = $lims_customer_data->email;
        $mail_data['reference_no'] = $lims_sale_data->reference_no;
        $mail_data['sale_status'] = $lims_sale_data->sale_status;
        $mail_data['payment_status'] = $lims_sale_data->payment_status;
        $mail_data['total_qty'] = $lims_sale_data->total_qty;
        $mail_data['total_price'] = $lims_sale_data->total_price;
        $mail_data['order_tax'] = $lims_sale_data->order_tax;
        $mail_data['order_tax_rate'] = $lims_sale_data->order_tax_rate;
        $mail_data['order_discount'] = $lims_sale_data->order_discount;
        $mail_data['shipping_cost'] = $lims_sale_data->shipping_cost;
        $mail_data['grand_total'] = $lims_sale_data->grand_total;
        $mail_data['paid_amount'] = $lims_sale_data->paid_amount;

        foreach ($lims_product_sale_data as $key => $product_sale_data) {
            $lims_product_data = Product::find($product_sale_data->product_id);
            if ($product_sale_data->variant_id) {
                $variant_data = Variant::find($product_sale_data->variant_id);
                $mail_data['products'][$key] = $lims_product_data->name . ' [' . ($variant_data ? $variant_data->name : '') . ']';
            } else {
                $mail_data['products'][$key] = $lims_product_data->name;
            }

            $mail_data['file'][$key] = ($lims_product_data->type == 'digital') ? url('/public/product/files') . '/' . $lims_product_data->file : '';
            $unit = Unit::find($product_sale_data->sale_unit_id);
            $mail_data['unit'][$key] = $unit ? $unit->unit_code : '';
            $mail_data['qty'][$key] = $product_sale_data->qty;
            $mail_data['total'][$key] = $product_sale_data->total;
        }

        $this->setMailInfo($mail_setting);
        try {
            Mail::to($mail_data['email'])->send(new SaleDetails($mail_data));
            $message = 'Mail sent successfully';
        } catch (\Exception $e) {
            $message = 'Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        }

        return redirect()->back()->with('message', $message);
    }

    /**
     * Today's sale report.
     */
    public function todaySale()
    {
        $today = date("Y-m-d");
        $data['total_sale_amount'] = Sale::whereDate('created_at', $today)->sum('grand_total');
        $data['total_payment'] = Payment::whereDate('created_at', $today)->sum('amount');
        $data['cash_payment'] = Payment::where('paying_method', 'Cash')->whereDate('created_at', $today)->sum('amount');
        $data['credit_card_payment'] = Payment::where('paying_method', 'Credit Card')->whereDate('created_at', $today)->sum('amount');
        $data['gift_card_payment'] = Payment::where('paying_method', 'Gift Card')->whereDate('created_at', $today)->sum('amount');
        $data['deposit_payment'] = Payment::where('paying_method', 'Deposit')->whereDate('created_at', $today)->sum('amount');
        $data['cheque_payment'] = Payment::where('paying_method', 'Cheque')->whereDate('created_at', $today)->sum('amount');
        $data['paypal_payment'] = Payment::where('paying_method', 'Paypal')->whereDate('created_at', $today)->sum('amount');
        $data['total_sale_return'] = Returns::whereDate('created_at', $today)->sum('grand_total');
        $data['total_expense'] = Expense::whereDate('created_at', $today)->sum('amount');
        $data['total_cash'] = $data['total_payment'] - ($data['total_sale_return'] + $data['total_expense']);
        return $data;
    }

    /**
     * Today's profit calculation.
     */
    public function todayProfit($warehouse_id)
    {
        $today = date("Y-m-d");
        if ($warehouse_id == 0) {
            $product_sale_data = Product_Sale::select(DB::raw('product_id, product_batch_id, sum(qty) as sold_qty, sum(total) as sold_amount'))
                ->whereDate('created_at', $today)
                ->groupBy('product_id', 'product_batch_id')
                ->get();
        } else {
            $product_sale_data = Sale::join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                ->select(DB::raw('product_sales.product_id, product_sales.product_batch_id, sum(product_sales.qty) as sold_qty, sum(product_sales.total) as sold_amount'))
                ->where('sales.warehouse_id', $warehouse_id)
                ->whereDate('sales.created_at', $today)
                ->groupBy('product_sales.product_id', 'product_sales.product_batch_id')
                ->get();
        }

        $product_revenue = 0;
        $product_cost = 0;
        $profit = 0;

        foreach ($product_sale_data as $product_sale) {
            if ($warehouse_id == 0) {
                if ($product_sale->product_batch_id) {
                    $product_purchase_data = ProductPurchase::where([
                        ['product_id', $product_sale->product_id],
                        ['product_batch_id', $product_sale->product_batch_id]
                    ])->get();
                } else {
                    $product_purchase_data = ProductPurchase::where('product_id', $product_sale->product_id)->get();
                }
            } else {
                if ($product_sale->product_batch_id) {
                    $product_purchase_data = Purchase::join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')
                        ->where([
                            ['product_purchases.product_id', $product_sale->product_id],
                            ['product_purchases.product_batch_id', $product_sale->product_batch_id],
                            ['purchases.warehouse_id', $warehouse_id]
                        ])->select('product_purchases.*')->get();
                } else {
                    $product_purchase_data = Purchase::join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')
                        ->where([
                            ['product_purchases.product_id', $product_sale->product_id],
                            ['purchases.warehouse_id', $warehouse_id]
                        ])->select('product_purchases.*')->get();
                }
            }

            $purchased_qty = 0;
            $purchased_amount = 0;
            $sold_qty = $product_sale->sold_qty;
            $product_revenue += $product_sale->sold_amount;
            foreach ($product_purchase_data as $product_purchase) {
                $purchased_qty += $product_purchase->qty;
                $purchased_amount += $product_purchase->total;
                if ($purchased_qty >= $sold_qty) {
                    $qty_diff = $purchased_qty - $sold_qty;
                    $unit_cost = $product_purchase->qty > 0 ? ($product_purchase->total / $product_purchase->qty) : 0;
                    $purchased_amount -= ($qty_diff * $unit_cost);
                    break;
                }
            }

            $product_cost += $purchased_amount;
            $profit += $product_sale->sold_amount - $purchased_amount;
        }

        $data['product_revenue'] = $product_revenue;
        $data['product_cost'] = $product_cost;
        if ($warehouse_id == 0) {
            $data['expense_amount'] = Expense::whereDate('created_at', $today)->sum('amount');
        } else {
            $data['expense_amount'] = Expense::where('warehouse_id', $warehouse_id)->whereDate('created_at', $today)->sum('amount');
        }

        $data['profit'] = $profit - $data['expense_amount'];
        return $data;
    }
}

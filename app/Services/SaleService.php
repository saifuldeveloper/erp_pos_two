<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Biller;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomField;
use App\Models\Delivery;
use App\Models\GiftCard;
use App\Models\MailSetting;
use App\Models\Payment;
use App\Models\PaymentWithCheque;
use App\Models\PaymentWithCreditCard;
use App\Models\PaymentWithGiftCard;
use App\Models\PaymentWithPaypal;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\ProductReturn;
use App\Models\Returns;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Table;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Traits\TenantInfo;
use App\Traits\MailInfo;
use App\Traits\FileHandleTrait;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ProductType;
use App\Enums\SaleStatus;
use App\Mail\PaymentDetails;
use App\Mail\SaleDetails;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SaleService
{
    use TenantInfo;
    use MailInfo;
    use FileHandleTrait;

    protected SaleRepositoryInterface $saleRepository;
    protected WarehouseRepositoryInterface $warehouseRepository;
    protected AccountRepositoryInterface $accountRepository;

    /**
     * SaleService constructor.
     *
     * @param SaleRepositoryInterface $saleRepository
     * @param WarehouseRepositoryInterface $warehouseRepository
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(
        SaleRepositoryInterface $saleRepository,
        WarehouseRepositoryInterface $warehouseRepository,
        AccountRepositoryInterface $accountRepository
    ) {
        $this->saleRepository = $saleRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->accountRepository = $accountRepository;
    }

    /**
     * Get index form data for sale list.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexFormData(Request $request): array
    {
        $warehouseId = $request->input('warehouse_id', 0);
        $saleStatus = $request->input('sale_status', 0);
        $paymentStatus = $request->input('payment_status', 0);
        $brandId = $request->input('brand_id', 0);
        $saleType = $request->input('sale_type', '');

        if ($request->input('starting_date')) {
            $startDate = $request->input('starting_date');
            $endDate = $request->input('ending_date');
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $startDate)) {
                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
            }
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $endDate)) {
                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
            }
        } else {
            $startDate = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
            $endDate = date("Y-m-d");
        }

        $warehouses = $this->warehouseRepository->getActiveWarehouses();
        $accounts = $this->accountRepository->getActiveAccounts();
        $posSetting = Cache::remember('pos_setting', 60 * 60 * 24 * 365, function () {
            return PosSetting::latest()->first();
        });

        $rewardPointSetting = Cache::remember('reward_point_setting', 60 * 60 * 24 * 30, function () {
            return RewardPointSetting::latest()->first();
        });

        $customFields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        $options = $posSetting ? explode(',', $posSetting->payment_options) : [];

        return [
            'starting_date'                 => $startDate,
            'ending_date'                   => $endDate,
            'warehouse_id'                  => $warehouseId,
            'sale_status'                   => $saleStatus,
            'payment_status'                => $paymentStatus,
            'lims_gift_card_list'           => GiftCard::where("is_active", true)->get(),
            'lims_pos_setting_data'         => $posSetting,
            'lims_reward_point_setting_data'=> $rewardPointSetting,
            'lims_account_list'             => $accounts,
            'lims_warehouse_list'           => $warehouses,
            'options'                       => $options,
            'numberOfInvoice'               => Sale::count(),
            'custom_fields'                 => $customFields,
            'field_name'                    => $fieldNames,
            'lims_courier_list'             => Courier::where('is_active', true)->get(),
            'lims_brand_list'               => Brand::where('is_active', true)->get(),
            'brand_id'                      => $brandId,
            'sale_type'                     => $saleType,
        ];
    }

    /**
     * Process DataTables server-side response for sale list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getSaleDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
            7 => 'grand_total',
            8 => 'paid_amount',
        ];

        $filters = [
            'starting_date'  => $request->input('starting_date'),
            'ending_date'    => $request->input('ending_date'),
            'warehouse_id'   => $request->input('warehouse_id'),
            'sale_status'    => $request->input('sale_status'),
            'payment_status' => $request->input('payment_status'),
            'sale_type'      => $request->input('sale_type'),
        ];

        $totalData = $this->saleRepository->countTotalSales($filters);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'sales.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';
        $searchValue = $request->input('search.value');

        $customFields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        $sales = $this->saleRepository->getFilteredSalesForDataTable($start, $limit, $order, $dir, $filters, $searchValue, $fieldNames);
        $totalFiltered = $this->saleRepository->countFilteredSalesForDataTable($filters, $searchValue);

        $saleIds = $sales->pluck('id')->toArray();
        $brandId = $request->input('brand_id');

        $returnedAmounts = DB::table('returns')
            ->whereIn('sale_id', $saleIds)
            ->selectRaw('sale_id, SUM(grand_total) as total')
            ->groupBy('sale_id')
            ->pluck('total', 'sale_id');

        $purchaseTotalsQuery = DB::table('product_sales as ps')
            ->leftJoin(
                DB::raw('(SELECT product_id, variant_id, AVG(net_unit_cost) as net_unit_cost FROM product_purchases GROUP BY product_id, variant_id) as pp'),
                function ($join) {
                    $join->on('ps.product_id', '=', 'pp.product_id')
                        ->on(function ($q) {
                            $q->on('ps.variant_id', '=', 'pp.variant_id')
                                ->orWhere(function ($q) {
                                    $q->whereNull('ps.variant_id')
                                        ->whereNull('pp.variant_id');
                                });
                        });
                }
            );

        if ($brandId) {
            $purchaseTotalsQuery->join('products as p', 'ps.product_id', '=', 'p.id')
                ->where('p.brand_id', $brandId);
        }

        $purchaseTotals = $purchaseTotalsQuery->whereIn('ps.sale_id', $saleIds)
            ->selectRaw('ps.sale_id, SUM(ps.qty * COALESCE(pp.net_unit_cost, 0)) as total')
            ->groupBy('ps.sale_id')
            ->pluck('total', 'ps.sale_id');

        $productSalesData = DB::table('product_sales as ps')
            ->join('products as p', 'ps.product_id', '=', 'p.id')
            ->whereIn('ps.sale_id', $saleIds)
            ->select('ps.sale_id', 'ps.qty', 'ps.total', 'p.brand_id')
            ->get()
            ->groupBy('sale_id');

        $coupons = Coupon::pluck('code', 'id');
        $currencies = Currency::pluck('code', 'id');

        $decimal = (int) (config('decimal') ?: 2);
        $data = [];
        $dateFormat = config('date_format') ?: 'd-m-Y';

        foreach ($sales as $key => $sale) {
            $nestedData = [];
            $nestedData['id'] = $sale->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date($dateFormat, strtotime($sale->created_at->toDateString()));
            $nestedData['reference_no'] = $sale->reference_no;
            $nestedData['biller'] = $sale->biller ? ($sale->biller->name . ' (' . $sale->biller->company_name . ')') : 'N/A';

            $customerName = $sale->customer ? $sale->customer->name : 'N/A';
            $customerPhone = $sale->customer ? $sale->customer->phone_number : '';
            $customerDeposit = $sale->customer ? ($sale->customer->deposit - $sale->customer->expense) : 0;
            $customerPoints = $sale->customer ? $sale->customer->points : 0;
            $nestedData['customer'] = $customerName . '<br>' . $customerPhone
                . '<input type="hidden" class="deposit" value="' . $customerDeposit . '" />'
                . '<input type="hidden" class="points" value="' . $customerPoints . '" />';

            $sale_status_map = [
                1 => ['badge-success', trans('file.Completed')],
                2 => ['badge-danger', trans('file.Pending')],
                3 => ['badge-warning', trans('file.Draft')],
                4 => ['badge-danger', trans('file.Returned')],
                5 => ['badge-danger', trans('file.In Progress')],
            ];
            [$badge, $sale_status_label] = $sale_status_map[$sale->sale_status] ?? ['badge-secondary', 'Unknown'];
            $nestedData['sale_status'] = '<div class="badge ' . $badge . '">' . $sale_status_label . '</div>';

            $payment_status_map = [
                1 => ['badge-danger', trans('file.Pending')],
                2 => ['badge-danger', trans('file.Due')],
                3 => ['badge-warning', trans('file.Partial')],
                4 => ['badge-success', trans('file.Paid')],
            ];
            [$pbadge, $plabel] = $payment_status_map[$sale->payment_status] ?? ['badge-success', trans('file.Paid')];
            $nestedData['payment_status'] = '<div class="badge ' . $pbadge . '">' . $plabel . '</div>';

            $returnedAmount = $returnedAmounts[$sale->id] ?? 0;
            $purchaseTotal = $purchaseTotals[$sale->id] ?? 0;
            $couponCode = $coupons[$sale->coupon_id] ?? null;
            $currencyCode = $currencies[$sale->currency_id] ?? 'N/A';

            $ratio = 1.0;
            $brandQty = 0;
            $items = $productSalesData[$sale->id] ?? collect();
            if ($brandId) {
                $invoiceProductTotal = 0;
                $brandProductTotal = 0;
                foreach ($items as $ps) {
                    $invoiceProductTotal += $ps->total;
                    if ($ps->brand_id == $brandId) {
                        $brandProductTotal += $ps->total;
                        $brandQty += $ps->qty;
                    }
                }
                $ratio = $invoiceProductTotal > 0 ? ($brandProductTotal / $invoiceProductTotal) : 0;
            } else {
                $brandQty = $items->sum('qty');
            }

            $apportionedGrandTotal = $sale->grand_total * $ratio;
            $apportionedReturnedAmount = $returnedAmount * $ratio;
            $apportionedPaidAmount = $sale->paid_amount * $ratio;
            $apportionedDue = $apportionedGrandTotal - $apportionedReturnedAmount - $apportionedPaidAmount;

            $nestedData['total_quantity'] = $brandQty;
            $nestedData['purchase_total'] = number_format((float) $purchaseTotal, $decimal);
            $nestedData['grand_total'] = number_format((float) $apportionedGrandTotal, $decimal);
            $nestedData['returned_amount'] = number_format((float) $apportionedReturnedAmount, $decimal);
            $nestedData['paid_amount'] = number_format((float) $apportionedPaidAmount, $decimal);
            $nestedData['due'] = number_format((float) $apportionedDue, $decimal);

            foreach ($fieldNames as $fieldName) {
                $nestedData[$fieldName] = $sale->$fieldName;
            }

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <a href="' . route('sale.invoice', $sale->id) . '" class="btn btn-link"><i class="fa fa-copy"></i> ' . trans('file.Generate Invoice') . '</a>
                            </li>
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("sales-edit", $allPermissions)) {
                $editUrl = $sale->sale_status != 3
                    ? route('sales.edit', $sale->id)
                    : url('sales/' . $sale->id . '/create');
                $options .= '<li>
                    <a href="' . $editUrl . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            if (in_array("sale-payment-index", $allPermissions)) {
                $options .= '<li>
                    <button type="button" class="get-payment btn btn-link" data-id="' . $sale->id . '"><i class="fa fa-money"></i> ' . trans('file.View Payment') . '</button>
                    </li>';
            }
            if (in_array("sale-payment-add", $allPermissions)) {
                $options .= '<li>
                    <button type="button" class="add-payment btn btn-link" data-id="' . $sale->id . '" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> ' . trans('file.Add Payment') . '</button>
                    </li>';
            }
            $options .= '<li>
                <button type="button" class="add-delivery btn btn-link" data-id="' . $sale->id . '"><i class="fa fa-truck"></i> ' . trans('file.Add Delivery') . '</button>
                </li>';
            if (in_array("sales-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["sales.destroy", $sale->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $nestedData['sale'] = [
                '[ "' . date(config('date_format') . ' (h:i A)', strtotime($sale->created_at)) . '"',
                ' "' . $sale->reference_no . '"',
                ' "' . $sale_status_label . '"',
                ' "' . @$sale->biller->name . '"',
                ' "' . @$sale->biller->company_name . '"',
                ' "' . @$sale->biller->email . '"',
                ' "' . @$sale->biller->phone_number . '"',
                ' "' . @$sale->biller->address . '"',
                ' "' . @$sale->biller->city . '"',
                ' "' . ($sale->customer ? $sale->customer->name : 'N/A') . '"',
                ' "' . ($sale->customer ? $sale->customer->phone_number : '') . '"',
                ' "' . ($sale->customer ? $sale->customer->address : '') . '"',
                ' "' . ($sale->customer ? $sale->customer->city : '') . '"',
                ' "' . $sale->id . '"',
                ' "' . $sale->total_tax . '"',
                ' "' . $sale->total_discount . '"',
                ' "' . $sale->total_price . '"',
                ' "' . $sale->order_tax . '"',
                ' "' . $sale->order_tax_rate . '"',
                ' "' . $sale->order_discount . '"',
                ' "' . $sale->shipping_cost . '"',
                ' "' . $sale->grand_total . '"',
                ' "' . $sale->paid_amount . '"',
                ' "' . $sale->sale_note . '"',
                ' "' . preg_replace('/[\n\r]/', "<br>", (string) $sale->staff_note) . '"',
                ' "' . @$sale->user->name . '"',
                ' "' . @$sale->user->email . '"',
                ' "' . @$sale->warehouse->name . '"',
                ' "' . $couponCode . '"',
                ' "' . $sale->coupon_discount . '"',
                ' "' . $sale->document . '"',
                ' "' . $currencyCode . '"',
                ' "' . $sale->exchange_rate . '"',
                ' "' . $sale->order_discount_type . '"',
                ' "' . $sale->order_discount_value . '"]',
            ];

            $data[] = $nestedData;
        }

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * Get create form data.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_pos_setting_data = PosSetting::latest()->first();
        $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
        $options = $lims_pos_setting_data ? explode(',', $lims_pos_setting_data->payment_options) : [];

        $currency_list = Currency::where('is_active', true)->get();
        $numberOfInvoice = Sale::count();
        $custom_fields = CustomField::where('belongs_to', 'sale')->get();
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        $accounts = Account::where('is_active', true)->get();

        return compact(
            'currency_list',
            'accounts',
            'lims_customer_list',
            'lims_warehouse_list',
            'lims_biller_list',
            'lims_pos_setting_data',
            'lims_tax_list',
            'lims_reward_point_setting_data',
            'options',
            'numberOfInvoice',
            'custom_fields',
            'lims_customer_group_all'
        );
    }

    /**
     * Get edit form data.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_sale_data = Sale::findOrFail($id);
        $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
        $custom_fields = CustomField::where('belongs_to', 'sale')->get();
        $currency_list = Currency::where('is_active', true)->get();

        return compact(
            'currency_list',
            'lims_customer_list',
            'lims_warehouse_list',
            'lims_biller_list',
            'lims_tax_list',
            'lims_sale_data',
            'lims_product_sale_data',
            'custom_fields'
        );
    }

    /**
     * Get POS form data.
     *
     * @return array
     */
    public function getPosFormData(): array
    {
        $lims_customer_list = Cache::remember('customer_list', 60 * 60 * 24, function () {
            return Customer::where('is_active', true)->get();
        });
        $lims_customer_group_all = Cache::remember('customer_group_list', 60 * 60 * 24, function () {
            return CustomerGroup::where('is_active', true)->get();
        });
        $lims_warehouse_list = Cache::remember('warehouse_list', 60 * 60 * 24 * 365, function () {
            return Warehouse::where('is_active', true)->get();
        });
        $lims_biller_list = Cache::remember('biller_list', 60 * 60 * 24 * 30, function () {
            return Biller::where('is_active', true)->get();
        });
        $lims_pos_setting_data = Cache::remember('pos_setting', 60 * 60 * 24 * 30, function () {
            return PosSetting::latest()->first();
        });
        $lims_reward_point_setting_data = Cache::remember('reward_point_setting', 60 * 60 * 24 * 30, function () {
            return RewardPointSetting::latest()->first();
        });
        $lims_tax_list = Cache::remember('tax_list', 60 * 60 * 24 * 30, function () {
            return Tax::where('is_active', true)->get();
        });
        $lims_product_list = Cache::remember('product_list', 60 * 60 * 24, function () {
            return Product::select('id', 'name', 'code', 'image', 'is_batch', 'is_imei')
                ->ActiveFeatured()
                ->whereNull('is_variant')
                ->get();
        });
        $lims_product_list_with_variant = Cache::remember('product_list_with_variant', 60 * 60 * 24, function () {
            return Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->ActiveFeatured()
                ->whereNotNull('is_variant')
                ->select('products.id', 'products.name', 'product_variants.item_code', 'products.image', 'product_variants.id as product_variant_id', 'product_variants.additional_price', 'products.is_batch', 'products.is_imei')
                ->get();
        });
        $lims_brand_list = Cache::remember('brand_list', 60 * 60 * 24 * 30, function () {
            return Brand::where('is_active', true)->get();
        });
        $lims_category_list = Cache::remember('category_list', 60 * 60 * 24 * 30, function () {
            return Category::where('is_active', true)->get();
        });
        $lims_table_list = Cache::remember('table_list', 60 * 60 * 24 * 30, function () {
            return Table::where('is_active', true)->get();
        });
        $lims_coupon_list = Cache::remember('coupon_list', 60 * 60 * 24 * 30, function () {
            return Coupon::where('is_active', true)->get();
        });

        $currency_list = Currency::where('is_active', true)->get();
        $numberOfInvoice = Sale::count();
        $custom_fields = CustomField::where('belongs_to', 'sale')->get();
        $options = $lims_pos_setting_data ? explode(',', $lims_pos_setting_data->payment_options) : [];
        $accounts = Account::where('is_active', true)->get();
        $product_number = count($lims_product_list);

        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $recent_sale = Sale::with('customer')->select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where([
                ['sale_status', 1],
                ['user_id', Auth::id()]
            ])->orderBy('id', 'desc')->take(10)->get();
            $recent_draft = Sale::with('customer')->select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where([
                ['sale_status', 3],
                ['user_id', Auth::id()]
            ])->orderBy('id', 'desc')->take(10)->get();
        } else {
            $recent_sale = Sale::with('customer')->select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where('sale_status', 1)->orderBy('id', 'desc')->take(10)->get();
            $recent_draft = Sale::with('customer')->select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where('sale_status', 3)->orderBy('id', 'desc')->take(10)->get();
        }

        return compact(
            'currency_list',
            'accounts',
            'lims_customer_list',
            'lims_customer_group_all',
            'lims_warehouse_list',
            'lims_product_list',
            'lims_product_list_with_variant',
            'lims_biller_list',
            'lims_pos_setting_data',
            'lims_tax_list',
            'options',
            'lims_brand_list',
            'lims_category_list',
            'lims_table_list',
            'lims_coupon_list',
            'numberOfInvoice',
            'custom_fields',
            'lims_reward_point_setting_data',
            'product_number',
            'recent_sale',
            'recent_draft'
        );
    }

    /**
     * Main store function wrapped in DB transaction.
     *
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {
        $rules = [
            'warehouse_id' => 'required',
        ];

        if (!isset($data['sale_type']) || $data['sale_type'] !== 'website') {
            $rules['biller_id'] = 'required';
            $rules['customer_id'] = 'required';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($data) {
            if (isset($data['sale_type']) && $data['sale_type'] === 'website') {
                $customer = Customer::where('phone_number', $data['customer_info']['phone_number'])->first();
                if (!$customer) {
                    $customer = $this->createCustomer($data['customer_info']);
                }
                $data['customer_id'] = $customer->id;
            }

            if (empty($data['biller_id'])) {
                $pos_setting = PosSetting::latest()->first();
                if ($pos_setting && $pos_setting->biller_id) {
                    $data['biller_id'] = $pos_setting->biller_id;
                } else {
                    $firstBiller = Biller::where('is_active', true)->first();
                    $data['biller_id'] = $firstBiller ? $firstBiller->id : 1;
                }
            }

            $data['user_id'] = Auth::id() ? Auth::id() : 1;

            $cash_register_data = CashRegister::where([
                ['user_id', $data['user_id']],
                ['warehouse_id', $data['warehouse_id']],
                ['status', true]
            ])->first();

            if ($cash_register_data) {
                $data['cash_register_id'] = $cash_register_data->id;
            }

            if (isset($data['created_at'])) {
                $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            } else {
                $data['created_at'] = date("Y-m-d H:i:s");
            }

            if (!empty($data['pos'])) {
                if (!isset($data['reference_no'])) {
                    $data['reference_no'] = 'posr-' . date("Ymd") . '-' . date("his");
                }
                $balance = $data['grand_total'] - $data['paid_amount'];
                if ($balance > 0 || $balance < 0) {
                    $data['payment_status'] = 2;
                } else {
                    $data['payment_status'] = 4;
                }
                if (!empty($data['draft'])) {
                    $data['sale_status'] = 3;
                    $data['grand_total'] = $data['paying_amount'] = $data['paid_amount'] = 0;
                }
            } else {
                if (!isset($data['reference_no'])) {
                    $data['reference_no'] = 'sr-' . date("Ymd") . '-' . date("his");
                }
            }

            $document = $data['document'] ?? null;
            if ($document instanceof UploadedFile) {
                $v = Validator::make(
                    ['extension' => strtolower($document->getClientOriginalExtension())],
                    ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                );
                if ($v->fails()) {
                    throw new ValidationException($v);
                }
                $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
                $documentName = date("Ymdhis");
                if (!config('database.connections.saas_landlord')) {
                    $documentName = $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                } else {
                    $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                }
                $data['document'] = $documentName;
            }

            if (!empty($data['coupon_active'])) {
                $lims_coupon_data = Coupon::find($data['coupon_id']);
                if ($lims_coupon_data) {
                    $lims_coupon_data->used += 1;
                    $lims_coupon_data->save();
                }
            }

            $sale = Sale::create($data);
            $mail_data = $this->productSaleStore($data, $sale);

            if ($data['sale_status'] == '1') {
                $message = 'Sale created successfully';
            } elseif ($data['sale_status'] == '2') {
                $message = 'Sale pending successfully';
            } elseif ($data['sale_status'] == '3') {
                $message = 'Draft created successfully';
            } else {
                $message = 'Sale created successfully';
            }

            return [
                'sale'      => $sale,
                'mail_data' => $mail_data,
                'message'   => $message,
            ];
        });
    }

    private function createCustomer($customer_info)
    {
        $customer_info['customer_group_id'] = 1;
        $customer_info['is_active'] = true;
        return Customer::create($customer_info);
    }

    private function productSaleStore($data, $sale)
    {
        $product_id = $data['product_id'] ?? [];
        $product_batch_id = $data['product_batch_id'] ?? null;
        $imei_number = $data['imei_number'] ?? null;
        $product_code = $data['product_code'] ?? [];
        $qty = $data['qty'] ?? [];
        $sale_unit = $data['sale_unit'] ?? [];
        $net_unit_price = $data['net_unit_price'] ?? $data['unit_price'] ?? [];
        $discount = $data['discount'] ?? $data['product_discount'] ?? [];
        $tax_rate = $data['tax_rate'] ?? [];
        $tax = $data['tax'] ?? [];
        $total = $data['subtotal'] ?? $data['total'] ?? [];
        $product_sale = [];

        $mail_data = [];

        foreach ($product_id as $i => $id) {
            $product = Product::where('id', $id)->first();
            $product_sale['variant_id'] = null;
            $product_sale['product_batch_id'] = null;

            if ($data['sale_status'] == 1) {
                if ($sale_unit[$i] != 'n/a') {
                    $unit = Unit::where('unit_name', $sale_unit[$i])->first();
                    $sale_unit_id = $unit ? $unit->id : 0;
                    if ($unit && $unit->operator == '*') {
                        $quantity = $qty[$i] * $unit->operation_value;
                    } elseif ($unit && $unit->operator == '/') {
                        $quantity = $qty[$i] / $unit->operation_value;
                    } else {
                        $quantity = $qty[$i];
                    }
                } else {
                    $sale_unit_id = 0;
                    $quantity = $qty[$i];
                }

                if ($product && $product->is_variant) {
                    $variant = ProductVariant::where([
                        ['product_id', $id],
                        ['item_code', $product_code[$i]]
                    ])->first();
                    if ($variant) {
                        $product_sale['variant_id'] = $variant->variant_id;
                        $variant->decrement('qty', $quantity);
                    }
                }

                if ($product_batch_id && !empty($product_batch_id[$i])) {
                    $product_sale['product_batch_id'] = $product_batch_id[$i];
                    $product_batch_data = ProductBatch::find($product_batch_id[$i]);
                    if ($product_batch_data) {
                        $product_batch_data->decrement('qty', $quantity);
                    }
                }

                if ($product && $product->type === 'standard') {
                    $product->decrement('qty', $quantity);
                    $this->mergeProductWarehouseDuplicates($id, $product_sale['variant_id']);

                    $pw_query = Product_Warehouse::where('warehouse_id', $data['warehouse_id'])
                        ->where('product_id', $id);

                    if (!empty($product_sale['product_batch_id'])) {
                        $pw_query->where('product_batch_id', $product_sale['product_batch_id']);
                    }
                    if (!empty($product_sale['variant_id'])) {
                        $pw_query->where('variant_id', $product_sale['variant_id']);
                    }

                    $product_warehouse = $pw_query->first();
                    if ($product_warehouse) {
                        $product_warehouse->decrement('qty', $quantity);
                    }
                }
            } else {
                $sale_unit_id = 0;
            }

            $product_sale = array_merge($product_sale, [
                'sale_id'        => $sale->id,
                'product_id'     => $id,
                'qty'            => $qty[$i] ?? 1,
                'sale_unit_id'   => $sale_unit_id,
                'net_unit_price' => $net_unit_price[$i] ?? 0,
                'discount'       => $discount[$i] ?? 0,
                'tax_rate'       => $tax_rate[$i] ?? 0,
                'tax'            => $tax[$i] ?? 0,
                'total'          => $total[$i] ?? 0,
                'imei_number'    => $imei_number[$i] ?? null,
            ]);

            Product_Sale::create($product_sale);
        }

        if (isset($data['paid_amount']) && $data['paid_amount'] > 0) {
            $register = CashRegister::where([
                ['user_id', Auth::id() ?: 1],
                ['warehouse_id', $data['warehouse_id']],
                ['status', true]
            ])->first();
            $this->storePayment($data, $sale->id, $register);
        }

        return $mail_data;
    }

    private function storePayment($data, $sale_id, $register)
    {
        $payment = new Payment();
        $payment->user_id = Auth::id() ?: 1;
        $payment->sale_id = $sale_id;
        $payment->cash_register_id = $register ? $register->id : null;

        $payment->amount = $data['paid_amount'];
        $payment->change = ($data['paying_amount'] ?? $data['paid_amount']) - $data['paid_amount'];
        $payment->payment_reference = 'spr-' . date("Ymd") . "-" . date("his");
        $payment->paying_method = $this->getPayMethod($data['paid_by_id'] ?? 1);
        $payment->payment_note = $data['payment_note'] ?? null;
        $payment->account_id = $data['account_id'] ?? (Account::where('is_default', true)->value('id') ?? 1);

        $payment->save();

        return $payment;
    }

    private function getPayMethod($id)
    {
        return PaymentMethod::tryFrom((int) $id)?->label() ?? 'Cash';
    }

    private function mergeProductWarehouseDuplicates(int $product_id, ?int $variant_id)
    {
        $query = DB::table('product_warehouse')
            ->select('warehouse_id', 'product_batch_id', DB::raw('COUNT(*) as count'))
            ->where('product_id', $product_id);

        if ($variant_id !== null) {
            $query = $query->where('variant_id', $variant_id);
        } else {
            $query = $query->whereNull('variant_id');
        }

        $duplicates = $query->groupBy('warehouse_id', 'product_batch_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $rowsQuery = DB::table('product_warehouse')
                ->where('product_id', $product_id)
                ->where('warehouse_id', $dup->warehouse_id)
                ->where('product_batch_id', $dup->product_batch_id);

            if ($variant_id !== null) {
                $rowsQuery = $rowsQuery->where('variant_id', $variant_id);
            } else {
                $rowsQuery = $rowsQuery->whereNull('variant_id');
            }

            $rows = $rowsQuery->orderBy('id', 'asc')->get();

            $firstRow = $rows->first();
            $totalQty = $rows->sum('qty');

            DB::table('product_warehouse')
                ->where('id', $firstRow->id)
                ->update(['qty' => $totalQty]);

            $deleteIds = $rows->slice(1)->pluck('id')->toArray();
            DB::table('product_warehouse')
                ->whereIn('id', $deleteIds)
                ->delete();
        }
    }

    /**
     * Update an existing sale wrapped in DB transaction.
     *
     * @param int|string $id
     * @param array $data
     * @param UploadedFile|null $document
     * @return array
     */
    public function updateSale($id, array $data, ?UploadedFile $document = null): array
    {
        return DB::transaction(function () use ($id, $data, $document) {
            $sale = Sale::findOrFail($id);

            if ($document) {
                $v = Validator::make(
                    ['extension' => strtolower($document->getClientOriginalExtension())],
                    ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                );
                if ($v->fails()) {
                    throw new ValidationException($v);
                }
                $this->fileDelete('documents/sale/', $sale->document);
                $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
                $documentName = date("Ymdhis");
                if (!config('database.connections.saas_landlord')) {
                    $documentName = $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                } else {
                    $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                }
                $data['document'] = $documentName;
            }

            $balance = $data['grand_total'] - $data['paid_amount'];
            if ($balance < 0 || $balance > 0) {
                $data['payment_status'] = 2;
            } else {
                $data['payment_status'] = 4;
            }

            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            $data['created_at'] = date("Y-m-d", strtotime(str_replace("/", "-", $data['created_at'])));
            $product_id = $data['product_id'];
            $imei_number = $data['imei_number'] ?? [];
            $product_batch_id = $data['product_batch_id'] ?? null;
            $product_code = $data['product_code'];
            $product_variant_id = $data['product_variant_id'] ?? [];
            $qty = $data['qty'];
            $sale_unit = $data['sale_unit'];
            $net_unit_price = $data['net_unit_price'];
            $discount = $data['discount'];
            $tax_rate = $data['tax_rate'];
            $tax = $data['tax'];
            $total = $data['subtotal'];
            $old_product_id = [];
            $old_product_variant_id = [];
            $product_sale = [];

            // 1. Revert stock of previous items
            foreach ($lims_product_sale_data as $key => $product_sale_data) {
                $old_product_id[] = $product_sale_data->product_id;
                $old_product_variant_id[$key] = null;
                $lims_product_data = Product::find($product_sale_data->product_id);
                if (!$lims_product_data) {
                    continue;
                }

                $lims_product_warehouse_data = null;

                if ($sale->isStatus(SaleStatus::COMPLETED) && $lims_product_data->isType(ProductType::COMBO)) {
                    $product_list = explode(",", $lims_product_data->product_list);
                    $variant_list = $lims_product_data->variant_list ? explode(",", $lims_product_data->variant_list) : [];
                    $qty_list = explode(",", $lims_product_data->qty_list);

                    foreach ($product_list as $index => $child_id) {
                        $child_data = Product::find($child_id);
                        if (!$child_data) {
                            continue;
                        }

                        if (count($variant_list) && !empty($variant_list[$index])) {
                            $child_product_variant_data = ProductVariant::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]]
                            ])->first();

                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]],
                                ['warehouse_id', $sale->warehouse_id],
                            ])->first();

                            if ($child_product_variant_data) {
                                $child_product_variant_data->qty += $product_sale_data->qty * $qty_list[$index];
                                $child_product_variant_data->save();
                            }
                        } else {
                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['warehouse_id', $sale->warehouse_id],
                            ])->first();
                        }

                        $child_data->qty += $product_sale_data->qty * $qty_list[$index];
                        if ($child_warehouse_data) {
                            $child_warehouse_data->qty += $product_sale_data->qty * $qty_list[$index];
                            $child_warehouse_data->save();
                        }
                        $child_data->save();
                    }
                } elseif (($sale->sale_status == 1) && ($product_sale_data->sale_unit_id != 0)) {
                    $old_product_qty = $product_sale_data->qty;
                    $lims_sale_unit_data = Unit::find($product_sale_data->sale_unit_id);
                    if ($lims_sale_unit_data) {
                        if ($lims_sale_unit_data->operator == '*') {
                            $old_product_qty = $old_product_qty * $lims_sale_unit_data->operation_value;
                        } else {
                            $old_product_qty = $old_product_qty / $lims_sale_unit_data->operation_value;
                        }
                    }

                    if ($product_sale_data->variant_id) {
                        $lims_product_variant_data = ProductVariant::select('id', 'qty')->FindExactProduct($product_sale_data->product_id, $product_sale_data->variant_id)->first();
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($product_sale_data->product_id, $product_sale_data->variant_id, $sale->warehouse_id)->first();
                        if ($lims_product_variant_data) {
                            $old_product_variant_id[$key] = $lims_product_variant_data->id;
                            $lims_product_variant_data->qty += $old_product_qty;
                            $lims_product_variant_data->save();
                        }
                    } elseif ($product_sale_data->product_batch_id) {
                        $lims_product_warehouse_data = Product_Warehouse::where([
                            ['product_id', $product_sale_data->product_id],
                            ['product_batch_id', $product_sale_data->product_batch_id],
                            ['warehouse_id', $sale->warehouse_id]
                        ])->first();

                        $product_batch_data = ProductBatch::find($product_sale_data->product_batch_id);
                        if ($product_batch_data) {
                            $product_batch_data->qty += $old_product_qty;
                            $product_batch_data->save();
                        }
                    } else {
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($product_sale_data->product_id, $sale->warehouse_id)->first();
                    }

                    $lims_product_data->qty += $old_product_qty;
                    if ($lims_product_warehouse_data) {
                        $lims_product_warehouse_data->qty += $old_product_qty;
                        $lims_product_warehouse_data->save();
                    }
                    $lims_product_data->save();
                }

                if ($product_sale_data->imei_number && $lims_product_warehouse_data) {
                    if ($lims_product_warehouse_data->imei_number) {
                        $lims_product_warehouse_data->imei_number .= ',' . $product_sale_data->imei_number;
                    } else {
                        $lims_product_warehouse_data->imei_number = $product_sale_data->imei_number;
                    }
                    $lims_product_warehouse_data->save();
                }

                if ($product_sale_data->variant_id && !(in_array($old_product_variant_id[$key], $product_variant_id))) {
                    $product_sale_data->delete();
                } elseif (!(in_array($old_product_id[$key], $product_id))) {
                    $product_sale_data->delete();
                }
            }

            // 2. Deduct new stock
            foreach ($product_id as $key => $pro_id) {
                $lims_product_data = Product::find($pro_id);
                $product_sale['variant_id'] = null;

                if ($lims_product_data->isType(ProductType::COMBO) && $data['sale_status'] == SaleStatus::COMPLETED->value) {
                    $product_list = explode(",", $lims_product_data->product_list);
                    $variant_list = $lims_product_data->variant_list ? explode(",", $lims_product_data->variant_list) : [];
                    $qty_list = explode(",", $lims_product_data->qty_list);

                    foreach ($product_list as $index => $child_id) {
                        $child_data = Product::find($child_id);
                        if (count($variant_list) && !empty($variant_list[$index])) {
                            $child_product_variant_data = ProductVariant::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]],
                            ])->first();

                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]],
                                ['warehouse_id', $data['warehouse_id']],
                            ])->first();
                        } else {
                            $child_product_variant_data = null;
                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['warehouse_id', $data['warehouse_id']],
                            ])->first();
                        }

                        if (!$child_warehouse_data) {
                            $child_warehouse_data = new Product_Warehouse();
                            $child_warehouse_data->product_id = $child_id;
                            $child_warehouse_data->warehouse_id = $data['warehouse_id'];
                            $child_warehouse_data->variant_id = (count($variant_list) && !empty($variant_list[$index])) ? $variant_list[$index] : null;
                            $child_warehouse_data->qty = 0;
                            $child_warehouse_data->price = $child_data->price;
                        }

                        $required_qty = $qty[$key] * $qty_list[$index];
                        if (config('without_stock') == 'no') {
                            if ($child_warehouse_data->qty < $required_qty) {
                                throw new \Exception("The quantity for combo component '{$child_data->name}' exceeds available stock in this warehouse.");
                            }
                            if ($child_product_variant_data && $child_product_variant_data->qty < $required_qty) {
                                throw new \Exception("The quantity for combo component variant '{$child_data->name}' exceeds available stock.");
                            }
                        }

                        if ($child_product_variant_data) {
                            $child_product_variant_data->qty -= $required_qty;
                            $child_product_variant_data->save();
                        }
                        $child_data->qty -= $required_qty;
                        $child_warehouse_data->qty -= $required_qty;
                        $child_data->save();
                        $child_warehouse_data->save();
                    }
                }

                if ($sale_unit[$key] != 'n/a') {
                    $lims_sale_unit_data = Unit::where('unit_name', $sale_unit[$key])->first();
                    $sale_unit_id = $lims_sale_unit_data ? $lims_sale_unit_data->id : 0;
                    if ($data['sale_status'] == 1 && $lims_sale_unit_data) {
                        $new_product_qty = $qty[$key];
                        if ($lims_sale_unit_data->operator == '*') {
                            $new_product_qty = $new_product_qty * $lims_sale_unit_data->operation_value;
                        } else {
                            $new_product_qty = $new_product_qty / $lims_sale_unit_data->operation_value;
                        }

                        if ($lims_product_data->is_variant) {
                            $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($pro_id, $product_code[$key])->first();
                            $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($pro_id, $lims_product_variant_data->variant_id, $data['warehouse_id'])->first();
                            $product_sale['variant_id'] = $lims_product_variant_data->variant_id;
                        } elseif (!empty($product_batch_id[$key])) {
                            $lims_product_warehouse_data = Product_Warehouse::where([
                                ['product_id', $pro_id],
                                ['product_batch_id', $product_batch_id[$key]],
                                ['warehouse_id', $data['warehouse_id']]
                            ])->first();
                            $product_batch_data = ProductBatch::find($product_batch_id[$key]);
                        } else {
                            $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($pro_id, $data['warehouse_id'])->first();
                        }

                        if (!$lims_product_warehouse_data) {
                            $lims_product_warehouse_data = new Product_Warehouse();
                            $lims_product_warehouse_data->product_id = $pro_id;
                            $lims_product_warehouse_data->warehouse_id = $data['warehouse_id'];
                            $lims_product_warehouse_data->variant_id = $lims_product_data->is_variant ? $lims_product_variant_data->variant_id : null;
                            $lims_product_warehouse_data->qty = 0;
                            $lims_product_warehouse_data->price = $lims_product_data->price;
                        }

                        if (config('without_stock') == 'no') {
                            if ($lims_product_warehouse_data->qty < $new_product_qty) {
                                throw new \Exception("The quantity for product '{$lims_product_data->name}' exceeds available stock in this warehouse.");
                            }
                            if ($lims_product_data->is_variant && $lims_product_variant_data->qty < $new_product_qty) {
                                throw new \Exception("The quantity for product variant '{$lims_product_data->name}' exceeds available stock.");
                            }
                            if (!empty($product_batch_id[$key]) && $product_batch_data->qty < $new_product_qty) {
                                throw new \Exception("The quantity for product batch '{$lims_product_data->name}' exceeds available stock.");
                            }
                        }

                        if ($lims_product_data->is_variant) {
                            $lims_product_variant_data->qty -= $new_product_qty;
                            $lims_product_variant_data->save();
                        } elseif (!empty($product_batch_id[$key])) {
                            $product_batch_data->qty -= $new_product_qty;
                            $product_batch_data->save();
                        }
                        $lims_product_data->qty -= $new_product_qty;
                        $lims_product_warehouse_data->qty -= $new_product_qty;
                        $lims_product_data->save();
                        $lims_product_warehouse_data->save();
                    }
                } else {
                    $sale_unit_id = 0;
                }

                if (!empty($imei_number[$key]) && isset($lims_product_warehouse_data)) {
                    $imei_numbers = explode(",", $imei_number[$key]);
                    $all_imei_numbers = explode(",", $lims_product_warehouse_data->imei_number);
                    foreach ($imei_numbers as $number) {
                        if (($j = array_search($number, $all_imei_numbers)) !== false) {
                            unset($all_imei_numbers[$j]);
                        }
                    }
                    $lims_product_warehouse_data->imei_number = implode(",", $all_imei_numbers);
                    $lims_product_warehouse_data->save();
                }

                $product_sale['sale_id'] = $id;
                $product_sale['product_id'] = $pro_id;
                $product_sale['imei_number'] = $imei_number[$key] ?? null;
                $product_sale['qty'] = $qty[$key];
                $product_sale['sale_unit_id'] = $sale_unit_id;
                $product_sale['net_unit_price'] = $net_unit_price[$key];
                $product_sale['discount'] = $discount[$key];
                $product_sale['tax_rate'] = $tax_rate[$key];
                $product_sale['tax'] = $tax[$key];
                $product_sale['total'] = $total[$key];

                if ($product_sale['variant_id'] && in_array($product_variant_id[$key] ?? null, $old_product_variant_id)) {
                    Product_Sale::where([
                        ['product_id', $pro_id],
                        ['variant_id', $product_sale['variant_id']],
                        ['sale_id', $id]
                    ])->update($product_sale);
                } elseif ($product_sale['variant_id'] === null && in_array($pro_id, $old_product_id)) {
                    Product_Sale::where([
                        ['sale_id', $id],
                        ['product_id', $pro_id]
                    ])->update($product_sale);
                } else {
                    Product_Sale::create($product_sale);
                }
            }

            $sale->update($data);

            // Custom fields update
            $custom_field_data = [];
            $custom_fields = CustomField::where('belongs_to', 'sale')->select('name', 'type')->get();
            foreach ($custom_fields as $custom_field) {
                $field_name = str_replace(' ', '_', strtolower($custom_field->name));
                if (isset($data[$field_name])) {
                    if ($custom_field->type == 'checkbox' || $custom_field->type == 'multi_select') {
                        $custom_field_data[$field_name] = implode(",", $data[$field_name]);
                    } else {
                        $custom_field_data[$field_name] = $data[$field_name];
                    }
                }
            }
            if (count($custom_field_data)) {
                DB::table('sales')->where('id', $sale->id)->update($custom_field_data);
            }

            return [
                'sale'    => $sale,
                'message' => 'Sale updated successfully',
            ];
        });
    }

    /**
     * Delete a sale and revert stock wrapped in DB transaction.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteSale($id): bool
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            $customer = Customer::find($sale->customer_id);

            // 1. Delete associated Returns & ProductReturns
            $return_ids = Returns::where('sale_id', $id)->pluck('id')->toArray();
            if (count($return_ids)) {
                ProductReturn::whereIn('return_id', $return_ids)->delete();
                Returns::whereIn('id', $return_ids)->delete();
            }

            // 2. Revert stock for all Product_Sale items
            $productSales = Product_Sale::where('sale_id', $id)->get();
            foreach ($productSales as $product_sale) {
                $product = Product::find($product_sale->product_id);
                if (!$product) {
                    continue;
                }

                if ($sale->isStatus(SaleStatus::COMPLETED) && $product->isType(ProductType::COMBO)) {
                    $product_list = explode(",", $product->product_list);
                    $variant_list = $product->variant_list ? explode(",", $product->variant_list) : [];
                    $qty_list = explode(",", $product->qty_list);

                    foreach ($product_list as $index => $child_id) {
                        $child_data = Product::find($child_id);
                        if (!$child_data) {
                            continue;
                        }

                        if (count($variant_list) && !empty($variant_list[$index])) {
                            $child_product_variant_data = ProductVariant::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]]
                            ])->first();

                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]],
                                ['warehouse_id', $sale->warehouse_id],
                            ])->first();

                            if ($child_product_variant_data) {
                                $child_product_variant_data->qty += $product_sale->qty * $qty_list[$index];
                                $child_product_variant_data->save();
                            }
                        } else {
                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['warehouse_id', $sale->warehouse_id],
                            ])->first();
                        }

                        $child_data->qty += $product_sale->qty * $qty_list[$index];
                        if ($child_warehouse_data) {
                            $child_warehouse_data->qty += $product_sale->qty * $qty_list[$index];
                            $child_warehouse_data->save();
                        }
                        $child_data->save();
                    }
                } elseif ($sale->sale_status == 1 && $product_sale->sale_unit_id != 0) {
                    $sale_unit = Unit::find($product_sale->sale_unit_id);
                    if ($sale_unit) {
                        if ($sale_unit->operator == '*') {
                            $quantity = $product_sale->qty * $sale_unit->operation_value;
                        } else {
                            $quantity = $product_sale->qty / $sale_unit->operation_value;
                        }
                    } else {
                        $quantity = $product_sale->qty;
                    }

                    if ($product_sale->variant_id) {
                        $productVariant = ProductVariant::where([
                            ['product_id', $product_sale->product_id],
                            ['variant_id', $product_sale->variant_id]
                        ])->first();
                        $productWarehouse = Product_Warehouse::FindProductWithVariant($product_sale->product_id, $product_sale->variant_id, $sale->warehouse_id)->first();

                        if ($productVariant) {
                            $productVariant->qty += $quantity;
                            $productVariant->save();
                        }
                    } elseif ($product_sale->product_batch_id) {
                        $productWarehouse = Product_Warehouse::where([
                            ['product_id', $product_sale->product_id],
                            ['product_batch_id', $product_sale->product_batch_id],
                            ['warehouse_id', $sale->warehouse_id]
                        ])->first();

                        $batch = ProductBatch::find($product_sale->product_batch_id);
                        if ($batch) {
                            $batch->qty += $quantity;
                            $batch->save();
                        }
                    } else {
                        $productWarehouse = Product_Warehouse::FindProductWithoutVariant($product_sale->product_id, $sale->warehouse_id)->first();
                    }

                    $product->qty += $quantity;
                    if ($productWarehouse) {
                        $productWarehouse->qty += $quantity;
                        $productWarehouse->save();
                    }
                    $product->save();
                }

                if ($product_sale->imei_number) {
                    $productWarehouse = Product_Warehouse::where([
                        ['product_id', $product_sale->product_id],
                        ['warehouse_id', $sale->warehouse_id]
                    ])->first();
                    if ($productWarehouse) {
                        if ($productWarehouse->imei_number) {
                            $productWarehouse->imei_number .= ',' . $product_sale->imei_number;
                        } else {
                            $productWarehouse->imei_number = $product_sale->imei_number;
                        }
                        $productWarehouse->save();
                    }
                }

                $product_sale->delete();
            }

            // 3. Revert payments, account balance, gift cards, points, deposits
            $payments = Payment::where('sale_id', $id)->get();
            foreach ($payments as $payment) {
                $account = Account::find($payment->account_id);
                if ($account) {
                    $account->total_balance -= $payment->amount;
                    $account->save();
                }
                if ($payment->paying_method == 'Gift Card') {
                    $giftCardPayment = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                    if ($giftCardPayment) {
                        $giftCard = GiftCard::find($giftCardPayment->gift_card_id);
                        if ($giftCard) {
                            $giftCard->expense -= $payment->amount;
                            $giftCard->save();
                        }
                        $giftCardPayment->delete();
                    }
                } elseif ($payment->paying_method == 'Credit Card') {
                    PaymentWithCreditCard::where('payment_id', $payment->id)->delete();
                } elseif ($payment->paying_method == 'Cheque') {
                    $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                    if ($cheque) {
                        if ($cheque->cheque_file) {
                            @unlink(public_path('documents/cheque/' . $cheque->cheque_file));
                        }
                        $cheque->delete();
                    }
                } elseif ($payment->paying_method == 'Paypal') {
                    PaymentWithPaypal::where('payment_id', $payment->id)->delete();
                } elseif ($payment->paying_method == 'Deposit' && $customer) {
                    $customer->expense -= $payment->amount;
                    $customer->save();
                } elseif ($payment->paying_method == 'Points' && $customer) {
                    $customer->points += $payment->used_points;
                    $customer->save();
                }
                $payment->delete();
            }

            // 4. Delete deliveries
            Delivery::where('sale_id', $id)->delete();

            // 5. Delete document
            if ($sale->document) {
                $this->fileDelete('documents/sale/', $sale->document);
            }

            return (bool) $sale->delete();
        });
    }

    /**
     * Delete multiple sales wrapped in DB transaction.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleSales(array $ids): bool
    {
        return DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $this->deleteSale($id);
            }
            return true;
        });
    }

    /**
     * Add a payment to a sale wrapped in DB transaction.
     *
     * @param array $data
     * @param UploadedFile|null $chequeFile
     * @return array
     */
    public function addPayment(array $data, ?UploadedFile $chequeFile = null): array
    {
        return DB::transaction(function () use ($data, $chequeFile) {
            $amount = $data['amount'] ?? 0.00;
            $sale = Sale::findOrFail($data['sale_id']);
            $customer = Customer::find($sale->customer_id);

            $sale->paid_amount += $amount;
            $balance = $sale->grand_total - $sale->paid_amount;
            if ($balance > 0 || $balance < 0) {
                $sale->payment_status = 2;
            } elseif ($balance == 0) {
                $sale->payment_status = 4;
            }

            $payingMethodMap = [
                1 => 'Cash',
                2 => 'Gift Card',
                3 => 'Credit Card',
                4 => 'Cheque',
                5 => 'Paypal',
                6 => 'Deposit',
                7 => 'Points',
            ];
            $payingMethod = $payingMethodMap[$data['paid_by_id'] ?? 1] ?? 'Cash';

            $cashRegister = CashRegister::where([
                ['user_id', Auth::id() ?: 1],
                ['warehouse_id', $sale->warehouse_id],
                ['status', true]
            ])->first();

            $payment = new Payment();
            $payment->user_id = Auth::id() ?: 1;
            $payment->sale_id = $sale->id;
            if ($cashRegister) {
                $payment->cash_register_id = $cashRegister->id;
            }
            $payment->account_id = $data['account_id'];
            $paymentReference = 'spr-' . date("Ymd") . '-' . date("his");
            $payment->payment_reference = $paymentReference;
            $payment->amount = $amount;
            $payment->change = ($data['paying_amount'] ?? $amount) - $amount;
            $payment->paying_method = $payingMethod;
            $payment->payment_note = $data['payment_note'] ?? null;
            $payment->due_payment = 1;
            $payment->save();
            $sale->save();

            $account = Account::find($data['account_id']);
            if ($account) {
                $account->total_balance += $amount;
                $account->save();
            }

            $paymentData = $data;
            $paymentData['payment_id'] = $payment->id;

            if ($payingMethod == 'Gift Card') {
                $giftCard = GiftCard::find($data['gift_card_id']);
                if ($giftCard) {
                    $giftCard->expense += $amount;
                    $giftCard->save();
                }
                PaymentWithGiftCard::create($paymentData);
            } elseif ($payingMethod == 'Credit Card') {
                $paymentData['customer_id'] = $sale->customer_id;
                $paymentData['customer_stripe_id'] = null;
                $paymentData['charge_id'] = null;
                PaymentWithCreditCard::create($paymentData);
            } elseif ($payingMethod == 'Cheque') {
                if ($chequeFile) {
                    $chequeName = date("Ymdhis") . '.' . $chequeFile->getClientOriginalExtension();
                    $chequeFile->move('public/documents/cheque', $chequeName);
                    $paymentData['cheque_file'] = $chequeName;
                }
                PaymentWithCheque::create($paymentData);
            } elseif ($payingMethod == 'Paypal') {
                PaymentWithPaypal::create([
                    'payment_id'     => $payment->id,
                    'transaction_id' => $payment->payment_reference ?? 'PAYPAL-' . time(),
                ]);
            } elseif ($payingMethod == 'Deposit' && $customer) {
                $customer->expense += $amount;
                $customer->save();
            } elseif ($payingMethod == 'Points' && $customer) {
                $rewardPointSetting = RewardPointSetting::latest()->first();
                $perPoint = ($rewardPointSetting && $rewardPointSetting->per_point_amount > 0) ? $rewardPointSetting->per_point_amount : 1;
                $usedPoints = ceil($amount / $perPoint);
                $payment->used_points = $usedPoints;
                $payment->save();
                $customer->points -= $usedPoints;
                $customer->save();
            }

            return ['payment' => $payment, 'sale' => $sale, 'message' => 'Payment created successfully'];
        });
    }

    /**
     * Update an existing payment wrapped in DB transaction.
     *
     * @param array $data
     * @param UploadedFile|null $chequeFile
     * @return array
     */
    public function updatePayment(array $data, ?UploadedFile $chequeFile = null): array
    {
        return DB::transaction(function () use ($data, $chequeFile) {
            $payment = Payment::findOrFail($data['payment_id']);
            $sale = Sale::findOrFail($payment->sale_id);
            $customer = Customer::find($sale->customer_id);

            $amountDiff = $payment->amount - $data['edit_amount'];
            $sale->paid_amount -= $amountDiff;
            $balance = $sale->grand_total - $sale->paid_amount;
            if ($balance > 0 || $balance < 0) {
                $sale->payment_status = 2;
            } elseif ($balance == 0) {
                $sale->payment_status = 4;
            }
            $sale->save();

            // Revert old account balance & add new account balance
            $oldAccount = Account::find($payment->account_id);
            if ($oldAccount) {
                $oldAccount->total_balance -= $payment->amount;
                $oldAccount->save();
            }
            $newAccount = Account::find($data['account_id']);
            if ($newAccount) {
                $newAccount->total_balance += $data['edit_amount'];
                $newAccount->save();
            }

            // Revert previous method effects
            if ($payment->paying_method == 'Deposit' && $customer) {
                $customer->expense -= $payment->amount;
                $customer->save();
            } elseif ($payment->paying_method == 'Points' && $customer) {
                $customer->points += $payment->used_points;
                $customer->save();
                $payment->used_points = 0;
            } elseif ($payment->paying_method == 'Gift Card') {
                $oldPaymentGiftCard = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                if ($oldPaymentGiftCard) {
                    $oldGiftCard = GiftCard::find($oldPaymentGiftCard->gift_card_id);
                    if ($oldGiftCard) {
                        $oldGiftCard->expense -= $payment->amount;
                        $oldGiftCard->save();
                    }
                }
            }

            $payingMethodMap = [
                1 => 'Cash',
                2 => 'Gift Card',
                3 => 'Credit Card',
                4 => 'Cheque',
                5 => 'Paypal',
                6 => 'Deposit',
                7 => 'Points',
            ];
            $newPayingMethod = $payingMethodMap[$data['edit_paid_by_id'] ?? 1] ?? 'Cash';
            $payment->paying_method = $newPayingMethod;

            if ($newPayingMethod == 'Gift Card') {
                $giftCard = GiftCard::find($data['gift_card_id']);
                if ($giftCard) {
                    $giftCard->expense += $data['edit_amount'];
                    $giftCard->save();
                }
                $paymentGiftCard = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                if ($paymentGiftCard) {
                    $paymentGiftCard->gift_card_id = $data['gift_card_id'];
                    $paymentGiftCard->save();
                } else {
                    PaymentWithGiftCard::create([
                        'payment_id'   => $payment->id,
                        'gift_card_id' => $data['gift_card_id'],
                    ]);
                }
            } elseif ($newPayingMethod == 'Credit Card') {
                $creditCard = PaymentWithCreditCard::where('payment_id', $payment->id)->first();
                if (!$creditCard) {
                    PaymentWithCreditCard::create([
                        'payment_id'         => $payment->id,
                        'customer_id'        => $sale->customer_id,
                        'customer_stripe_id' => null,
                        'charge_id'          => null,
                    ]);
                }
            } elseif ($newPayingMethod == 'Cheque') {
                $paymentCheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                $chequeName = null;
                if ($chequeFile) {
                    $chequeName = date("Ymdhis") . '.' . $chequeFile->getClientOriginalExtension();
                    $chequeFile->move('public/documents/cheque', $chequeName);
                }
                if ($paymentCheque) {
                    $paymentCheque->cheque_no = $data['edit_cheque_no'];
                    if ($chequeName) {
                        $paymentCheque->cheque_file = $chequeName;
                    }
                    $paymentCheque->save();
                } else {
                    PaymentWithCheque::create([
                        'payment_id'  => $payment->id,
                        'cheque_no'   => $data['edit_cheque_no'],
                        'cheque_file' => $chequeName,
                    ]);
                }
            } elseif ($newPayingMethod == 'Paypal') {
                $paypal = PaymentWithPaypal::where('payment_id', $payment->id)->first();
                if (!$paypal) {
                    PaymentWithPaypal::create([
                        'payment_id'     => $payment->id,
                        'transaction_id' => $payment->payment_reference ?? 'PAYPAL-' . time(),
                    ]);
                }
            } elseif ($newPayingMethod == 'Deposit' && $customer) {
                $customer->expense += $data['edit_amount'];
                $customer->save();
            } elseif ($newPayingMethod == 'Points' && $customer) {
                $rewardPointSetting = RewardPointSetting::latest()->first();
                $perPoint = ($rewardPointSetting && $rewardPointSetting->per_point_amount > 0) ? $rewardPointSetting->per_point_amount : 1;
                $usedPoints = ceil($data['edit_amount'] / $perPoint);
                $payment->used_points = $usedPoints;
                $customer->points -= $usedPoints;
                $customer->save();
            }

            $payment->account_id = $data['account_id'];
            $payment->amount = $data['edit_amount'];
            $payment->change = ($data['edit_paying_amount'] ?? $data['edit_amount']) - $data['edit_amount'];
            $payment->payment_note = $data['edit_payment_note'] ?? null;
            $payment->save();

            return ['payment' => $payment, 'sale' => $sale, 'message' => 'Payment updated successfully'];
        });
    }

    /**
     * Delete a payment wrapped in DB transaction.
     *
     * @param int|string $id
     * @return bool
     */
    public function deletePayment(int|string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $payment = Payment::findOrFail($id);
            $sale = Sale::findOrFail($payment->sale_id);
            $customer = Customer::find($sale->customer_id);

            $sale->paid_amount -= $payment->amount;
            $balance = $sale->grand_total - $sale->paid_amount;
            if ($balance > 0 || $balance < 0) {
                $sale->payment_status = 2;
            } elseif ($balance == 0) {
                $sale->payment_status = 4;
            }
            $sale->save();

            $account = Account::find($payment->account_id);
            if ($account) {
                $account->total_balance -= $payment->amount;
                $account->save();
            }

            if ($payment->paying_method == 'Gift Card') {
                $giftCardPayment = PaymentWithGiftCard::where('payment_id', $id)->first();
                if ($giftCardPayment) {
                    $giftCard = GiftCard::find($giftCardPayment->gift_card_id);
                    if ($giftCard) {
                        $giftCard->expense -= $payment->amount;
                        $giftCard->save();
                    }
                    $giftCardPayment->delete();
                }
            } elseif ($payment->paying_method == 'Credit Card') {
                PaymentWithCreditCard::where('payment_id', $id)->delete();
            } elseif ($payment->paying_method == 'Cheque') {
                $cheque = PaymentWithCheque::where('payment_id', $id)->first();
                if ($cheque) {
                    if ($cheque->cheque_file) {
                        @unlink(public_path('documents/cheque/' . $cheque->cheque_file));
                    }
                    $cheque->delete();
                }
            } elseif ($payment->paying_method == 'Paypal') {
                PaymentWithPaypal::where('payment_id', $id)->delete();
            } elseif ($payment->paying_method == 'Deposit' && $customer) {
                $customer->expense -= $payment->amount;
                $customer->save();
            } elseif ($payment->paying_method == 'Points' && $customer) {
                $customer->points += $payment->used_points;
                $customer->save();
            }

            return (bool) $payment->delete();
        });
    }

    /**
     * Import sale from CSV wrapped in DB transaction.
     *
     * @param UploadedFile $upload
     * @param array $data
     * @param UploadedFile|null $document
     * @return array
     */
    public function importSaleFromCsv(UploadedFile $upload, array $data, ?UploadedFile $document = null): array
    {
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            throw new \Exception('Please upload a CSV file');
        }

        $filePath = $upload->getRealPath();
        $file_handle = fopen($filePath, 'r');
        $i = 0;
        $product_data = [];
        $unit = [];
        $tax = [];
        $qty = [];
        $price = [];
        $discount = [];

        while (!feof($file_handle)) {
            $current_line = fgetcsv($file_handle);
            if ($current_line && $i > 0) {
                $prod = Product::where('code', $current_line[0])->first();
                if (!$prod) {
                    throw new \Exception("Product '{$current_line[0]}' does not exist!");
                }
                $product_data[] = $prod;

                $u = Unit::where('unit_code', $current_line[2])->first();
                if (!$u && $current_line[2] == 'n/a') {
                    $unit[] = 'n/a';
                } elseif (!$u) {
                    throw new \Exception("Sale unit '{$current_line[2]}' does not exist!");
                } else {
                    $unit[] = $u;
                }

                if (strtolower($current_line[5]) != "no tax") {
                    $t = Tax::where('name', $current_line[5])->first();
                    if (!$t) {
                        throw new \Exception("Tax '{$current_line[5]}' does not exist!");
                    }
                    $tax[] = $t;
                } else {
                    $tax[] = ['rate' => 0];
                }

                $qty[] = $current_line[1];
                $price[] = $current_line[3];
                $discount[] = $current_line[4];
            }
            $i++;
        }
        fclose($file_handle);

        return DB::transaction(function () use ($data, $document, $product_data, $unit, $tax, $qty, $price, $discount) {
            $data['reference_no'] = 'sr-' . date("Ymd") . '-' . date("his");
            $data['user_id'] = Auth::id() ?: 1;

            if ($document) {
                $v = Validator::make(
                    ['extension' => strtolower($document->getClientOriginalExtension())],
                    ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                );
                if ($v->fails()) {
                    throw new ValidationException($v);
                }
                $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
                $documentName = date("Ymdhis");
                if (!config('database.connections.saas_landlord')) {
                    $documentName = $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                } else {
                    $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                    $document->move('public/documents/sale', $documentName);
                }
                $data['document'] = $documentName;
            }

            $sale = Sale::create($data);

            foreach ($product_data as $key => $product) {
                $taxRate = is_array($tax[$key]) ? $tax[$key]['rate'] : $tax[$key]->rate;
                if ($product->tax_method == 1) {
                    $net_unit_price = $price[$key] - $discount[$key];
                    $product_tax = $net_unit_price * ($taxRate / 100) * $qty[$key];
                    $total = ($net_unit_price * $qty[$key]) + $product_tax;
                } elseif ($product->tax_method == 2) {
                    $net_unit_price = (100 / (100 + $taxRate)) * ($price[$key] - $discount[$key]);
                    $product_tax = ($price[$key] - $discount[$key] - $net_unit_price) * $qty[$key];
                    $total = ($price[$key] - $discount[$key]) * $qty[$key];
                }

                if ($data['sale_status'] == 1 && $unit[$key] != 'n/a') {
                    $sale_unit_id = $unit[$key]->id;
                    if ($unit[$key]->operator == '*') {
                        $quantity = $qty[$key] * $unit[$key]->operation_value;
                    } elseif ($unit[$key]->operator == '/') {
                        $quantity = $qty[$key] / $unit[$key]->operation_value;
                    }
                    $product->qty -= $quantity;
                    $product_warehouse = Product_Warehouse::where([
                        ['product_id', $product->id],
                        ['warehouse_id', $data['warehouse_id']]
                    ])->first();
                    if ($product_warehouse) {
                        $product_warehouse->qty -= $quantity;
                        $product_warehouse->save();
                    }
                    $product->save();
                } else {
                    $sale_unit_id = 0;
                }

                $product_sale = new Product_Sale();
                $product_sale->sale_id = $sale->id;
                $product_sale->product_id = $product->id;
                $product_sale->qty = $qty[$key];
                $product_sale->sale_unit_id = $sale_unit_id;
                $product_sale->net_unit_price = number_format((float) $net_unit_price, config('decimal') ?: 2, '.', '');
                $product_sale->discount = $discount[$key] * $qty[$key];
                $product_sale->tax_rate = $taxRate;
                $product_sale->tax = number_format((float) $product_tax, config('decimal') ?: 2, '.', '');
                $product_sale->total = number_format((float) $total, config('decimal') ?: 2, '.', '');
                $product_sale->save();

                $sale->total_qty += $qty[$key];
                $sale->total_discount += $discount[$key] * $qty[$key];
                $sale->total_tax += number_format((float) $product_tax, config('decimal') ?: 2, '.', '');
                $sale->total_price += number_format((float) $total, config('decimal') ?: 2, '.', '');
            }

            $sale->item = count($product_data);
            $sale->order_tax = ($sale->total_price - $sale->order_discount) * (($data['order_tax_rate'] ?? 0) / 100);
            $sale->grand_total = ($sale->total_price + $sale->order_tax + ($data['shipping_cost'] ?? 0)) - ($sale->order_discount ?? 0);
            $sale->save();

            return ['sale' => $sale, 'message' => 'Sale imported successfully'];
        });
    }
}

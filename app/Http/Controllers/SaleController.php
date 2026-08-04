<?php

namespace App\Http\Controllers;

use App\Mail\PaymentDetails;
use App\Mail\SaleDetails;
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
use App\Models\Expense;
use App\Models\GiftCard;
use App\Models\MailSetting;
use App\Models\Payment;
use App\Models\PaymentWithCheque;
use App\Models\PaymentWithCreditCard;
use App\Models\PaymentWithGiftCard;
use App\Models\PaymentWithPaypal;
use App\Models\PosSetting;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Enums\ProductType;
use App\Enums\SaleStatus;
use App\Enums\PaymentStatus;
use App\Models\ProductBatch;
use App\Models\ProductPurchase;
use App\Models\ProductReturn;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\Returns;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Table;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use NumberToWords\NumberToWords;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;
use Spatie\Permission\Models\Role;
use Srmklive\PayPal\Services\ExpressCheckout;
use Stripe\Charge;
use Stripe\Stripe;

class SaleController extends Controller
{
    use \App\Traits\TenantInfo;
    use \App\Traits\MailInfo;

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';

            if ($request->input('warehouse_id'))
                $warehouse_id = $request->input('warehouse_id');
            else
                $warehouse_id = 0;

            if ($request->input('sale_status'))
                $sale_status = $request->input('sale_status');
            else
                $sale_status = 0;

            if ($request->input('payment_status'))
                $payment_status = $request->input('payment_status');
            else
                $payment_status = 0;

            if ($request->input('brand_id'))
                $brand_id = $request->input('brand_id');
            else
                $brand_id = 0;
            if ($request->input('sale_type'))
                $sale_type = $request->input('sale_type');
            else
                $sale_type = '';

            if ($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $starting_date)) {
                    $starting_date = \Carbon\Carbon::createFromFormat('d-m-Y', $starting_date)->format('Y-m-d');
                }
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $ending_date)) {
                    $ending_date = \Carbon\Carbon::createFromFormat('d-m-Y', $ending_date)->format('Y-m-d');
                }
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
                $ending_date = date("Y-m-d");
            }

            $lims_gift_card_list = GiftCard::where("is_active", true)->get();
            $lims_pos_setting_data = PosSetting::latest()->first();
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_courier_list = Courier::where('is_active', true)->get();
            if ($lims_pos_setting_data)
                $options = explode(',', $lims_pos_setting_data->payment_options);
            else
                $options = [];
            $numberOfInvoice = Sale::count();
            $custom_fields = CustomField::where([
                ['belongs_to', 'sale'],
                ['is_table', true]
            ])->pluck('name');
            $field_name = [];
            foreach ($custom_fields as $fieldName) {
                $field_name[] = str_replace(" ", "_", strtolower($fieldName));
            }

            $lims_brand_list = Brand::where('is_active', true)->get();
            return view('backend.sale.index', compact('starting_date', 'ending_date', 'warehouse_id', 'sale_status', 'payment_status', 'lims_gift_card_list', 'lims_pos_setting_data', 'lims_reward_point_setting_data', 'lims_account_list', 'lims_warehouse_list', 'all_permission', 'options', 'numberOfInvoice', 'custom_fields', 'field_name', 'lims_courier_list', 'lims_brand_list', 'brand_id', 'sale_type'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function saleData(Request $request)
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
            7 => 'grand_total',
            8 => 'paid_amount',
        ];

        $warehouse_id = $request->input('warehouse_id');
        $sale_status = $request->input('sale_status');
        $payment_status = $request->input('payment_status');
        $brand_id = $request->input('brand_id');
        $sale_type = $request->input('sale_type');
        $starting_date = $request->input('starting_date');
        $ending_date = $request->input('ending_date');

        if ($starting_date && preg_match('/^\d{2}-\d{2}-\d{4}$/', $starting_date)) {
            $starting_date = \Carbon\Carbon::createFromFormat('d-m-Y', $starting_date)->format('Y-m-d');
        }
        if ($ending_date && preg_match('/^\d{2}-\d{2}-\d{4}$/', $ending_date)) {
            $ending_date = \Carbon\Carbon::createFromFormat('d-m-Y', $ending_date)->format('Y-m-d');
        }

        // ── Base query builder ──
        $baseQuery = fn() => Sale::query()
            ->whereDate('created_at', '>=', $starting_date)
            ->whereDate('created_at', '<=', $ending_date)
            ->when($sale_type, fn($q) => $q->where('sale_type', $sale_type))
            ->when($sale_status, fn($q) => $q->where('sale_status', $sale_status))
            ->when($payment_status, fn($q) => $q->where('payment_status', $payment_status))
            ->when(
                Auth::user()->role_id > 2 && config('staff_access') == 'own',
                fn($q) => $q->where('user_id', Auth::id())
            );

        $totalData = $baseQuery()->count();

        // ── Filtered base query for proper pagination counting ──
        $filteredBaseQuery = fn() => $baseQuery()
            ->when($warehouse_id, fn($q) => $q->where('warehouse_id', $warehouse_id))
            ->when($brand_id, fn($q) => $q->whereHas(
                'productSales.product',
                fn($q) => $q->where('brand_id', $brand_id)
            ));

        $totalFiltered = $filteredBaseQuery()->count();

        $limit = $request->input('length') != -1 ? $request->input('length') : $totalData;
        $start = $request->input('start');
        $orderCol = $request->input('order.0.column');
        $order = isset($columns[$orderCol]) ? 'sales.' . $columns[$orderCol] : 'sales.created_at';
        $dir = $request->input('order.0.dir');

        // ── Custom fields ──
        $custom_fields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_table', true],
        ])->pluck('name');

        $field_names = $custom_fields->map(
            fn($f) => str_replace(' ', '_', strtolower($f))
        )->toArray();

        // ── Main query ──
        $search = $request->input('search.value');

        if (empty($search)) {
            $q = $filteredBaseQuery()
                ->with(['biller', 'customer', 'warehouse', 'user', 'productSales.product']) // eager load
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $sales = $q->get();

        } else {
            $isOwn = Auth::user()->role_id > 2 && config('staff_access') == 'own';

            $q = Sale::query()
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->join('billers', 'sales.biller_id', '=', 'billers.id')
                ->select('sales.*')
                ->with(['biller', 'customer', 'warehouse', 'user', 'productSales.product']) // eager load
                ->when($sale_type, fn($q) => $q->where('sales.sale_type', $sale_type))
                ->when($warehouse_id, fn($q) => $q->where('sales.warehouse_id', $warehouse_id))
                ->when($brand_id, fn($q) => $q->whereHas(
                    'productSales.product',
                    fn($q) => $q->where('brand_id', $brand_id)
                ))
                ->when($sale_status, fn($q) => $q->where('sales.sale_status', $sale_status))
                ->when($payment_status, fn($q) => $q->where('sales.payment_status', $payment_status))
                ->where(function ($q) use ($search, $field_names) {
                    $q->whereDate(
                        'sales.created_at',
                        '=',
                        date('Y-m-d', strtotime(str_replace('/', '-', $search)))
                    )
                        ->orWhere('sales.reference_no', 'LIKE', "%{$search}%")
                        ->orWhere('customers.name', 'LIKE', "%{$search}%")
                        ->orWhere('customers.phone_number', 'LIKE', "%{$search}%")
                        ->orWhere('billers.name', 'LIKE', "%{$search}%");

                    foreach ($field_names as $field_name) {
                        $q->orWhere('sales.' . $field_name, 'LIKE', "%{$search}%");
                    }
                })
                ->when($isOwn, fn($q) => $q->where('sales.user_id', Auth::id()))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $sales = $q->get();

            // Re-count without offset and limit to set totalFiltered
            $countQuery = Sale::query()
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->join('billers', 'sales.biller_id', '=', 'billers.id')
                ->when($sale_type, fn($q) => $q->where('sales.sale_type', $sale_type))
                ->when($warehouse_id, fn($q) => $q->where('sales.warehouse_id', $warehouse_id))
                ->when($brand_id, fn($q) => $q->whereHas(
                    'productSales.product',
                    fn($q) => $q->where('brand_id', $brand_id)
                ))
                ->when($sale_status, fn($q) => $q->where('sales.sale_status', $sale_status))
                ->when($payment_status, fn($q) => $q->where('sales.payment_status', $payment_status))
                ->where(function ($q) use ($search, $field_names) {
                    $q->whereDate(
                        'sales.created_at',
                        '=',
                        date('Y-m-d', strtotime(str_replace('/', '-', $search)))
                    )
                        ->orWhere('sales.reference_no', 'LIKE', "%{$search}%")
                        ->orWhere('customers.name', 'LIKE', "%{$search}%")
                        ->orWhere('customers.phone_number', 'LIKE', "%{$search}%")
                        ->orWhere('billers.name', 'LIKE', "%{$search}%");

                    foreach ($field_names as $field_name) {
                        $q->orWhere('sales.' . $field_name, 'LIKE', "%{$search}%");
                    }
                })
                ->when($isOwn, fn($q) => $q->where('sales.user_id', Auth::id()));

            $totalFiltered = $countQuery->count();
        }

        // ════════════════════════════════════════════
        //  BATCH FETCH — loop  outside, no query inside loop
        // ════════════════════════════════════════════
        $sale_ids = $sales->pluck('id')->toArray();

        // ── Returns: sale_id => sum ──
        $returnedAmounts = DB::table('returns')
            ->whereIn('sale_id', $sale_ids)
            ->selectRaw('sale_id, SUM(grand_total) as total')
            ->groupBy('sale_id')
            ->pluck('total', 'sale_id');

        // ── Purchase totals: sale_id => sum ──

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

        if ($brand_id) {
            $purchaseTotalsQuery->join('products as p', 'ps.product_id', '=', 'p.id')
                ->where('p.brand_id', $brand_id);
        }

        $purchaseTotals = $purchaseTotalsQuery->whereIn('ps.sale_id', $sale_ids)
            ->selectRaw('ps.sale_id, SUM(ps.qty * COALESCE(pp.net_unit_cost, 0)) as total')
            ->groupBy('ps.sale_id')
            ->pluck('total', 'ps.sale_id');

        // ── Coupons: id => code ──
        $coupon_ids = $sales->pluck('coupon_id')->filter()->unique()->toArray();
        $coupons = Coupon::whereIn('id', $coupon_ids)
            ->pluck('code', 'id');

        // ── Currencies: id => code ──
        $currency_ids = $sales->pluck('currency_id')->filter()->unique()->toArray();
        $currencies = Currency::whereIn('id', $currency_ids)
            ->pluck('code', 'id');

        // ════════════════════════════════════════════
        //  LOOP — only data format  , query none inside loop
        // ════════════════════════════════════════════
        $data = [];

        foreach ($sales as $key => $sale) {

            $returned_amount = $returnedAmounts[$sale->id] ?? 0;
            $purchase_total = $purchaseTotals[$sale->id] ?? 0;
            $coupon_code = $coupons[$sale->coupon_id] ?? null;
            $currency_code = $currencies[$sale->currency_id] ?? 'N/A';

            // ── Calculate brand ratio and brand quantity if brand_id filter is applied ──
            $ratio = 1.0;
            $brand_qty = 0;
            if ($brand_id) {
                $invoice_product_total = 0;
                $brand_product_total = 0;
                foreach ($sale->productSales as $productSale) {
                    $invoice_product_total += $productSale->total;
                    if ($productSale->product && $productSale->product->brand_id == $brand_id) {
                        $brand_product_total += $productSale->total;
                        $brand_qty += $productSale->qty;
                    }
                }
                $ratio = $invoice_product_total > 0 ? ($brand_product_total / $invoice_product_total) : 0;
            } else {
                $brand_qty = 0;
                foreach ($sale->productSales as $productSale) {
                    $brand_qty += $productSale->qty;
                }
            }

            $nestedData['id'] = $sale->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date(
                config('date_format'),
                strtotime($sale->created_at->toDateString())
            );
            $nestedData['reference_no'] = $sale->reference_no;
            $nestedData['biller'] = $sale->biller->name ?? 'Not found';
            $nestedData['customer'] = $sale->customer->name
                . '<br>' . $sale->customer->phone_number
                . '<input type="hidden" class="deposit" value="'
                . ($sale->customer->deposit - $sale->customer->expense) . '" />'
                . '<input type="hidden" class="points" value="'
                . $sale->customer->points . '" />';

            // Sale status
            $sale_status_map = [
                1 => ['badge-success', trans('file.Completed')],
                2 => ['badge-danger', trans('file.Pending')],
                3 => ['badge-warning', trans('file.Draft')],
                4 => ['badge-danger', trans('file.Returned')],
                5 => ['badge-danger', trans('file.In Progress')],
            ];
            [$badge, $sale_status_label] = $sale_status_map[$sale->sale_status]
                ?? ['badge-secondary', 'Unknown'];
            $nestedData['sale_status'] =
                '<div class="badge ' . $badge . '">' . $sale_status_label . '</div>';

            // Payment status
            $payment_status_map = [
                1 => ['badge-danger', trans('file.Pending')],
                2 => ['badge-danger', trans('file.Due')],
                3 => ['badge-warning', trans('file.Partial')],
                4 => ['badge-success', trans('file.Paid')],
            ];
            [$pbadge, $plabel] = $payment_status_map[$sale->payment_status]
                ?? ['badge-success', trans('file.Paid')];
            $nestedData['payment_status'] =
                '<div class="badge ' . $pbadge . '">' . $plabel . '</div>';

            $nestedData['total_quantity'] = $brand_qty;

            // Apportion financial values using $ratio
            $apportioned_grand_total = $sale->grand_total * $ratio;
            $apportioned_returned_amount = $returned_amount * $ratio;
            $apportioned_paid_amount = $sale->paid_amount * $ratio;
            $apportioned_due = $apportioned_grand_total - $apportioned_returned_amount - $apportioned_paid_amount;

            $nestedData['purchase_total'] = number_format($purchase_total, config('decimal'));
            $nestedData['grand_total'] = number_format($apportioned_grand_total, config('decimal'));
            $nestedData['returned_amount'] = number_format($apportioned_returned_amount, config('decimal'));
            $nestedData['paid_amount'] = number_format($apportioned_paid_amount, config('decimal'));
            $nestedData['due'] = number_format($apportioned_due, config('decimal'));

            foreach ($field_names as $field_name) {
                $nestedData[$field_name] = $sale->$field_name;
            }

            // Options HTML
            $nestedData['options'] = '<div class="btn-group">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ' . trans("file.action") . ' <span class="caret"></span>
            </button>
            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                <li><a href="' . route('sale.invoice', $sale->id) . '" class="btn btn-link">
                    <i class="fa fa-copy"></i> ' . trans('file.Generate Invoice') . '</a></li>
                <li><button type="button" class="btn btn-link view">
                    <i class="fa fa-eye"></i> ' . trans('file.View') . '</button></li>';

            if (in_array("sales-edit", $request['all_permission'])) {
                $editUrl = $sale->sale_status != 3
                    ? route('sales.edit', $sale->id)
                    : url('sales/' . $sale->id . '/create');
                $nestedData['options'] .=
                    '<li><a href="' . $editUrl . '" class="btn btn-link">
                    <i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a></li>';
            }
            if (in_array("sale-payment-index", $request['all_permission']))
                $nestedData['options'] .=
                    '<li><button type="button" class="get-payment btn btn-link" data-id="'
                    . $sale->id . '"><i class="fa fa-money"></i> '
                    . trans('file.View Payment') . '</button></li>';

            if (in_array("sale-payment-add", $request['all_permission']))
                $nestedData['options'] .=
                    '<li><button type="button" class="add-payment btn btn-link" data-id="'
                    . $sale->id . '" data-toggle="modal" data-target="#add-payment">
                <i class="fa fa-plus"></i> ' . trans('file.Add Payment') . '</button></li>';

            $nestedData['options'] .=
                '<li><button type="button" class="add-delivery btn btn-link" data-id="'
                . $sale->id . '"><i class="fa fa-truck"></i> '
                . trans('file.Add Delivery') . '</button></li>';

            if (in_array("sales-delete", $request['all_permission']))
                $nestedData['options'] .=
                    \Form::open(["route" => ["sales.destroy", $sale->id], "method" => "DELETE"])
                    . '<li><button type="submit" class="btn btn-link" onclick="return confirmDelete()">
                    <i class="dripicons-trash"></i> ' . trans("file.delete") . '</button></li>'
                    . \Form::close() . '</ul></div>';

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
                ' "' . $sale->customer->name . '"',
                ' "' . $sale->customer->phone_number . '"',
                ' "' . $sale->customer->address . '"',
                ' "' . $sale->customer->city . '"',
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
                ' "' . preg_replace('/[\n\r]/', "<br>", $sale->staff_note) . '"',
                ' "' . @$sale->user->name . '"',
                ' "' . @$sale->user->email . '"',
                ' "' . @$sale->warehouse->name . '"',
                ' "' . $coupon_code . '"',
                ' "' . $sale->coupon_discount . '"',
                ' "' . $sale->document . '"',
                ' "' . $currency_code . '"',
                ' "' . $sale->exchange_rate . '"',
                ' "' . $sale->order_discount_type . '"',
                ' "' . $sale->order_discount_value . '"]',
            ];

            $data[] = $nestedData;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ]);
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-add')) {
            $lims_customer_list = Customer::where('is_active', true)->get();
            if (Auth::user()->role_id > 2 && Auth::user()->role_id != 3) {
                $lims_warehouse_list = Warehouse::where([
                    ['is_active', true],
                    ['id', Auth::user()->warehouse_id]
                ])->get();
                $lims_biller_list = Biller::where([
                    ['is_active', true],
                    ['id', Auth::user()->biller_id]
                ])->get();
            } else {
                $lims_warehouse_list = Warehouse::where('is_active', true)->get();
                $lims_biller_list = Biller::where('is_active', true)->get();
            }

            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_pos_setting_data = PosSetting::latest()->first();
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            if ($lims_pos_setting_data)
                $options = explode(',', $lims_pos_setting_data->payment_options);
            else
                $options = [];

            $currency_list = Currency::where('is_active', true)->get();
            $numberOfInvoice = Sale::count();
            $custom_fields = CustomField::where('belongs_to', 'sale')->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $accounts = Account::where('is_active', true)->get();
            return view('backend.sale.create', compact('currency_list', 'accounts', 'lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_pos_setting_data', 'lims_tax_list', 'lims_reward_point_setting_data', 'options', 'numberOfInvoice', 'custom_fields', 'lims_customer_group_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function store(Request $request, SaleService $saleService)
    {
        $result = $saleService->store($request->all());
        $sale = $result['sale'];
        // $mail_data = $result['mail_data'];
        $message = $result['message'];
        if ($sale->sale_status == '1')
            return redirect('sales/gen_invoice/' . $sale->id)->with('message', $message);
        elseif ($request->pos)
            return redirect('pos')->with('message', $message);
        else
            return redirect('sales')->with('message', $message);
    }
    public function sendMail(Request $request)
    {
        $data = $request->all();
        $lims_sale_data = Sale::find($data['sale_id']);
        $lims_product_sale_data = Product_Sale::where('sale_id', $data['sale_id'])->get();
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        $mail_setting = MailSetting::latest()->first();

        if (!$mail_setting) {
            return $this->setErrorMessage('Please Setup Your Mail Credentials First.');
        } else if ($lims_customer_data->email) {
            //collecting male data
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
                    $variant_data = Variant::select('name')->find($product_sale_data->variant_id);
                    $mail_data['products'][$key] = $lims_product_data->name . ' [' . $variant_data->name . ']';
                } else
                    $mail_data['products'][$key] = $lims_product_data->name;
                if ($lims_product_data->type == 'digital')
                    $mail_data['file'][$key] = url('/public/product/files') . '/' . $lims_product_data->file;
                else
                    $mail_data['file'][$key] = '';
                if ($product_sale_data->sale_unit_id) {
                    $lims_unit_data = Unit::find($product_sale_data->sale_unit_id);
                    $mail_data['unit'][$key] = $lims_unit_data->unit_code;
                } else
                    $mail_data['unit'][$key] = '';

                $mail_data['qty'][$key] = $product_sale_data->qty;
                $mail_data['total'][$key] = $product_sale_data->qty;
            }
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new SaleDetails($mail_data));
                return $this->setSuccessMessage('Mail sent successfully');
            } catch (\Exception $e) {
                return $this->setErrorMessage('Please Setup Your Mail Credentials First.');
            }
        } else
            return $this->setErrorMessage('Customer doesnt have email!');
    }

    public function getProduct($id)
    {
        $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id');
        if (config('without_stock') == 'no') {
            $query = $query->where([
                ['products.is_active', true],
                ['product_warehouse.qty', '>', 0]
            ]);
        } else {
            $query = $query->where([
                ['products.is_active', true]
            ]);
        }
        $lims_product_warehouse_data = $query->whereNull('product_warehouse.variant_id')
            ->whereNull('product_warehouse.product_batch_id')
            ->selectRaw('product_warehouse.product_id, products.is_embeded, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . (int)$id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('product_warehouse.product_id', 'products.is_embeded')
            ->get();

        $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id');

        if (config('without_stock') == 'no') {
            $query = $query->where([
                ['products.is_active', true],
                ['product_warehouse.qty', '>', 0]
            ]);
        } else {
            $query = $query->where([
                ['products.is_active', true]
            ]);
        }

        $lims_product_with_batch_warehouse_data = $query->whereNull('product_warehouse.variant_id')
            ->whereNotNull('product_warehouse.product_batch_id')
            ->selectRaw('product_warehouse.product_id, products.is_embeded, product_warehouse.product_batch_id, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . (int)$id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('product_warehouse.product_id', 'product_warehouse.product_batch_id', 'products.is_embeded')
            ->get();

        $query = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id');
        if (config('without_stock') == 'no') {
            $query = $query->where([
                ['products.is_active', true],
                ['product_warehouse.qty', '>', 0]
            ]);
        } else {
            $query = $query->where([
                ['products.is_active', true]
            ]);
        }
        $lims_product_with_variant_warehouse_data = $query->whereNotNull('product_warehouse.variant_id')
            ->selectRaw('product_warehouse.product_id, products.is_embeded, product_warehouse.variant_id, SUM(product_warehouse.qty) as qty, MAX(CASE WHEN product_warehouse.warehouse_id = ' . (int)$id . ' THEN product_warehouse.price ELSE NULL END) as price')
            ->groupBy('product_warehouse.product_id', 'product_warehouse.variant_id', 'products.is_embeded')
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
        //product without variant
        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            if ($product_warehouse->price !== null) {
                $product_price[] = $product_warehouse->price;
            } else {
                $product_price[] = $lims_product_data->price;
            }
            $product_code[] = $lims_product_data->code;
            $product_name[] = htmlspecialchars($lims_product_data->name);
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = $lims_product_data->product_list;
            $qty_list[] = $lims_product_data->qty_list;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            if ($product_warehouse->is_embeded)
                $is_embeded[] = $product_warehouse->is_embeded;
            else
                $is_embeded[] = 0;
        }
        //product with batches
        foreach ($lims_product_with_batch_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            if ($product_warehouse->price !== null) {
                $product_price[] = $product_warehouse->price;
            } else {
                $product_price[] = $lims_product_data->price;
            }
            $product_code[] = $lims_product_data->code;
            $product_name[] = htmlspecialchars($lims_product_data->name);
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = $lims_product_data->product_list;
            $qty_list[] = $lims_product_data->qty_list;
            $product_batch_data = ProductBatch::select('id', 'batch_no', 'expired_date')->find($product_warehouse->product_batch_id);
            $batch_no[] = $product_batch_data->batch_no;
            $product_batch_id[] = $product_batch_data->id;
            $expired_date[] = date(config('date_format'), strtotime($product_batch_data->expired_date));
            if ($product_warehouse->is_embeded)
                $is_embeded[] = $product_warehouse->is_embeded;
            else
                $is_embeded[] = 0;
        }
        //product with variant
        foreach ($lims_product_with_variant_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $lims_product_variant_data = ProductVariant::select('item_code', 'additional_price')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            if ($lims_product_variant_data) {
                if ($product_warehouse->price !== null) {
                    $product_price[] = $product_warehouse->price;
                } else {
                    $product_price[] = $lims_product_data->price + $lims_product_variant_data->additional_price;
                }
                $product_code[] = $lims_product_variant_data->item_code;
                $product_name[] = htmlspecialchars($lims_product_data->name);
                $product_type[] = $lims_product_data->type;
                $product_id[] = $lims_product_data->id;
                $product_list[] = $lims_product_data->product_list;
                $qty_list[] = $lims_product_data->qty_list;
                $batch_no[] = null;
                $product_batch_id[] = null;
                $expired_date[] = null;
                if ($product_warehouse->is_embeded)
                    $is_embeded[] = $product_warehouse->is_embeded;
                else
                    $is_embeded[] = 0;
            }
        }
        //retrieve product with type of digital, combo and service
        $lims_product_data = Product::whereNotIn('type', [ProductType::STANDARD->value])->where('is_active', true)->get();
        foreach ($lims_product_data as $product) {
            $product_qty[] = $product->qty;
            $product_price[] = $product->price;
            $product_code[] = $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            $is_embeded[] = 0;
        }
        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id, $expired_date, $is_embeded];
        return $product_data;
    }


    public function posSale()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-add')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';

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
            $default_warehouse_id = $lims_pos_setting_data->warehouse_id ?? 0;
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            $lims_tax_list = Cache::remember('tax_list', 60 * 60 * 24 * 30, function () {
                return Tax::where('is_active', true)->get();
            });

            $lims_product_list = Cache::remember('product_list', 60 * 60 * 24, function () {
                return Product::ActiveFeatured()->whereNull('is_variant')->get();
            });
            foreach ($lims_product_list as $key => $product) {
                $images = explode(",", $product->image);
                if ($images[0])
                    $product->base_image = $images[0];
                else
                    $product->base_image = 'zummXD2dvAtI.png';
                
                // Fetch quantity
                $product->qty = DB::table('product_warehouse')
                    ->where([
                        ['product_id', $product->id],
                        ['warehouse_id', $default_warehouse_id]
                    ])->whereNull('variant_id')
                    ->value('qty') ?? 0;
            }
            $lims_product_list_with_variant = Cache::remember('product_list_with_variant', 60 * 60 * 24, function () {
                return Product::ActiveFeatured()->whereNotNull('is_variant')->get();
            });

            foreach ($lims_product_list_with_variant as $product) {
                $images = explode(",", $product->image);
                if ($images[0])
                    $product->base_image = $images[0];
                else
                    $product->base_image = 'zummXD2dvAtI.png';
                $lims_product_variant_data = $product->variant()->orderBy('position')->get();
                $main_name = $product->name;
                $temp_arr = [];
                foreach ($lims_product_variant_data as $key => $variant) {
                    $cloned_product = clone ($product);
                    $cloned_product->name = $main_name . ' [' . $variant->name . ']';
                    $cloned_product->code = $variant->pivot['item_code'];
                    // Fetch quantity
                    $cloned_product->qty = DB::table('product_warehouse')
                        ->where([
                            ['product_id', $product->id],
                            ['variant_id', $variant->id],
                            ['warehouse_id', $default_warehouse_id]
                        ])->value('qty') ?? 0;
                    $lims_product_list[] = $cloned_product;
                }
            }

            $product_number = count($lims_product_list);
            if ($lims_pos_setting_data)
                $options = explode(',', $lims_pos_setting_data->payment_options);
            else
                $options = [];
            $lims_brand_list = Cache::remember('brand_list', 60 * 60 * 24 * 30, function () {
                return Brand::where('is_active', true)->get();
            });
            // $lims_category_list = Cache::remember('category_list', 60*60*24*30, function () {
            $lims_category_list = Category::where('is_active', 1)
                ->whereNotNull('parent_id')
                ->with('parent')
                ->get();
            // });


            $lims_table_list = Cache::remember('table_list', 60 * 60 * 24 * 30, function () {
                return Table::where('is_active', true)->get();
            });
            //return $lims_category_list;
            if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $recent_sale = Sale::select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where([
                    ['sale_status', 1],
                    ['user_id', Auth::id()]
                ])->orderBy('id', 'desc')->take(10)->get();
                $recent_draft = Sale::select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where([
                    ['sale_status', 3],
                    ['user_id', Auth::id()]
                ])->orderBy('id', 'desc')->take(10)->get();
            } else {
                $recent_sale = Sale::select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where('sale_status', 1)->orderBy('id', 'desc')->take(10)->get();
                $recent_draft = Sale::select('id', 'reference_no', 'customer_id', 'grand_total', 'created_at')->where('sale_status', 3)->orderBy('id', 'desc')->take(10)->get();
            }
            $lims_coupon_list = Cache::remember('coupon_list', 60 * 60 * 24 * 30, function () {
                return Coupon::where('is_active', true)->get();
            });
            $flag = 0;

            $currency_list = Currency::where('is_active', true)->get();
            $numberOfInvoice = Sale::count();
            $custom_fields = CustomField::where('belongs_to', 'sale')->get();

            $accounts = Account::where('is_active', true)->get();

            return view('backend.sale.pos', compact('accounts', 'currency_list', 'role', 'all_permission', 'lims_customer_list', 'lims_customer_group_all', 'lims_warehouse_list', 'lims_reward_point_setting_data', 'lims_product_list', 'product_number', 'lims_tax_list', 'lims_biller_list', 'lims_pos_setting_data', 'options', 'lims_brand_list', 'lims_category_list', 'lims_table_list', 'recent_sale', 'recent_draft', 'lims_coupon_list', 'flag', 'numberOfInvoice', 'custom_fields'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function createSale($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-edit')) {
            $lims_biller_list = Biller::where('is_active', true)->get();
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_sale_data = Sale::find($id);
            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            $lims_product_list = Product::where([
                ['featured', 1],
                ['is_active', true]
            ])->get();
            foreach ($lims_product_list as $key => $product) {
                $images = explode(",", $product->image);
                if ($images[0])
                    $product->base_image = $images[0];
                else
                    $product->base_image = 'zummXD2dvAtI.png';
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

            return view('backend.sale.create_sale', compact('currency_list', 'lims_biller_list', 'lims_customer_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_sale_data', 'lims_product_sale_data', 'lims_pos_setting_data', 'lims_brand_list', 'lims_category_list', 'lims_coupon_list', 'lims_product_list', 'product_number', 'lims_customer_group_all', 'lims_reward_point_setting_data'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getProductByFilter($category_id, $brand_id)
    {
        $data = [];
        $warehouse_id = request()->input('warehouse_id');
        if (!$warehouse_id || $warehouse_id == 'undefined') {
            $lims_pos_setting_data = DB::table('pos_settings')->latest()->first();
            $warehouse_id = $lims_pos_setting_data->warehouse_id ?? 0;
        }

        if (($category_id != 0) && ($brand_id != 0)) {
            $lims_product_list = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where([
                    ['products.is_active', true],
                    ['products.category_id', $category_id],
                    ['brand_id', $brand_id]
                ])->orWhere([
                        ['categories.parent_id', $category_id],
                        ['products.is_active', true],
                        ['brand_id', $brand_id]
                    ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')->get();
        } elseif (($category_id != 0) && ($brand_id == 0)) {
            $lims_product_list = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where([
                    ['products.is_active', true],
                    ['products.category_id', $category_id],
                ])->orWhere([
                        ['categories.parent_id', $category_id],
                        ['products.is_active', true]
                    ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')->get();
        } elseif (($category_id == 0) && ($brand_id != 0)) {
            $lims_product_list = Product::where([
                ['brand_id', $brand_id],
                ['is_active', true]
            ])
                ->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')
                ->get();
        } else
            $lims_product_list = Product::where('is_active', true)->get();

        $index = 0;
        foreach ($lims_product_list as $product) {
            if ($product->is_variant) {
                $lims_product_data = Product::select('id')->find($product->id);
                $lims_product_variant_data = $lims_product_data->variant()->orderBy('position')->get();
                foreach ($lims_product_variant_data as $key => $variant) {
                    $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
                    $data['code'][$index] = $variant->pivot['item_code'];
                    $images = explode(",", $product->image);
                    $data['image'][$index] = $images[0];
                    $data['qty'][$index] = DB::table('product_warehouse')
                        ->where([
                            ['product_id', $product->id],
                            ['variant_id', $variant->id],
                            ['warehouse_id', $warehouse_id]
                        ])->value('qty') ?? 0;
                    $index++;
                }
            } else {
                $data['name'][$index] = $product->name;
                $data['code'][$index] = $product->code;
                $images = explode(",", $product->image);
                $data['image'][$index] = $images[0];
                $data['qty'][$index] = DB::table('product_warehouse')
                    ->where([
                        ['product_id', $product->id],
                        ['warehouse_id', $warehouse_id]
                    ])->whereNull('variant_id')
                    ->value('qty') ?? 0;
                $index++;
            }
        }
        return $data;
    }

    public function getFeatured()
    {
        $data = [];
        $warehouse_id = request()->input('warehouse_id');
        if (!$warehouse_id || $warehouse_id == 'undefined') {
            $lims_pos_setting_data = DB::table('pos_settings')->latest()->first();
            $warehouse_id = $lims_pos_setting_data->warehouse_id ?? 0;
        }

        $lims_product_list = Product::where([
            ['is_active', true],
            ['featured', true]
        ])->select('products.id', 'products.name', 'products.code', 'products.image', 'products.is_variant')->get();

        $index = 0;
        foreach ($lims_product_list as $product) {
            if ($product->is_variant) {
                $lims_product_data = Product::select('id')->find($product->id);
                $lims_product_variant_data = $lims_product_data->variant()->orderBy('position')->get();
                foreach ($lims_product_variant_data as $key => $variant) {
                    $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
                    $data['code'][$index] = $variant->pivot['item_code'];
                    $images = explode(",", $product->image);
                    $data['image'][$index] = $images[0];
                    $data['qty'][$index] = DB::table('product_warehouse')
                        ->where([
                            ['product_id', $product->id],
                            ['variant_id', $variant->id],
                            ['warehouse_id', $warehouse_id]
                        ])->value('qty') ?? 0;
                    $index++;
                }
            } else {
                $data['name'][$index] = $product->name;
                $data['code'][$index] = $product->code;
                $images = explode(",", $product->image);
                $data['image'][$index] = $images[0];
                $data['qty'][$index] = DB::table('product_warehouse')
                    ->where([
                        ['product_id', $product->id],
                        ['warehouse_id', $warehouse_id]
                    ])->whereNull('variant_id')
                    ->value('qty') ?? 0;
                $index++;
            }
        }
        return $data;
    }

    public function getCustomerGroup($id)
    {
        $lims_customer_data = Customer::find($id);
        $lims_customer_group_data = CustomerGroup::find($lims_customer_data->customer_group_id);
        return $lims_customer_group_data->percentage;
    }

    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_info = explode("?", $request['data']);
        $customer_id = $product_info[1] ?? null;
        $qty = $product_info[2] ?? null;
        $product_code = explode("(", $product_info[0]);
        $product_code[0] = rtrim($product_code[0], " ");
        $product_variant_id = null;
        $parent_variant_id = null;
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

        $search_code = $product_code[0];
        $normalized_code = str_replace(' ', '-', $search_code);

        \Log::info("limsProductSearch input: " . $request['data'] . " | warehouse_id: " . $request->input('warehouse_id'));
        \Log::info("search_code: '" . $search_code . "' | normalized_code: '" . $normalized_code . "'");

        $lims_product_data = Product::where(function($q) use ($search_code, $normalized_code) {
            $q->where('code', $search_code)
              ->orWhere('code', $normalized_code);
        })->where('is_active', true)->first();

        if (!$lims_product_data) {
            \Log::info("Not found in products. Searching variants...");
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where('products.is_active', true)
                ->where(function($q) use ($search_code, $normalized_code) {
                    $q->where('product_variants.item_code', $search_code)
                      ->orWhere('product_variants.item_code', $normalized_code);
                })->first();
            if ($lims_product_data) {
                \Log::info("Found in variants! Product ID: " . $lims_product_data->id);
                $product_variant_id = $lims_product_data->product_variant_id;
                $parent_variant_id = $lims_product_data->variant_id;
            } else {
                \Log::info("Not found in variants!");
            }
        }

        if (!$lims_product_data) {
            \Log::info("limsProductSearch returning nokey");
            return 'nokey';
        }

        if ($lims_product_data && $lims_product_data->is_variant && !$parent_variant_id) {
            $pv = DB::table('product_variants')
                ->where('product_id', $lims_product_data->id)
                ->where(function($q) use ($search_code, $normalized_code) {
                    $q->where('item_code', $search_code)
                      ->orWhere('item_code', $normalized_code);
                })
                ->first();
            if ($pv) {
                $parent_variant_id = $pv->variant_id;
                $lims_product_data->additional_price = $pv->additional_price;
            }
        }

        $warehouse_id = $request->input('warehouse_id');
        if ($warehouse_id) {
            if ($lims_product_data->is_variant) {
                $pw = DB::table('product_warehouse')
                    ->where('product_id', $lims_product_data->id)
                    ->where('variant_id', $parent_variant_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->first();
            } else {
                $pw = DB::table('product_warehouse')
                    ->where('product_id', $lims_product_data->id)
                    ->whereNull('variant_id')
                    ->whereNull('product_batch_id')
                    ->where('warehouse_id', $warehouse_id)
                    ->first();
            }
            if ($pw && $pw->price !== null) {
                $lims_product_data->price = $pw->price;
                $lims_product_data->additional_price = 0;
            }
        }

        $product[] = $lims_product_data->name;
        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->item_code;
            $lims_product_data->price += $lims_product_data->additional_price;
        } else
            $product[] = $lims_product_data->code;

        $no_discount = 1;
        foreach ($all_discount as $key => $discount) {
            $product_list = explode(",", $discount->product_list);
            $days = explode(",", $discount->days);

            if (($discount->applicable_for == 'All' || in_array($lims_product_data->id, $product_list)) && ($todayDate >= $discount->valid_from && $todayDate <= $discount->valid_till && in_array(date('D'), $days) && $qty >= $discount->minimum_qty && $qty <= $discount->maximum_qty)) {
                if ($discount->type == 'flat') {
                    $product[] = $lims_product_data->price - $discount->value;
                } elseif ($discount->type == 'percentage') {
                    $product[] = $lims_product_data->price - ($lims_product_data->price * ($discount->value / 100));
                }
                $no_discount = 0;
                break;
            } else {
                continue;
            }
        }

        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date && $no_discount) {
            $product[] = $lims_product_data->promotion_price;
        } elseif ($no_discount)
            $product[] = $lims_product_data->price;

        if ($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $lims_product_data->tax_method;
        if ($lims_product_data->isType(ProductType::STANDARD)) {
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                ->orWhere('id', $lims_product_data->unit_id)
                ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
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
            $product[] = 'n/a' . ',';
            $product[] = 'n/a' . ',';
            $product[] = 'n/a' . ',';
        }
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;
        $product[] = $lims_product_data->is_variant;
        $product[] = $qty;
        $product[] = $lims_product_data->price;
        $product[] = $lims_product_data->price - $product[2];

        $warehouse_id = $request->input('warehouse_id');
        if ($lims_product_data->isType(ProductType::STANDARD)) {
            if ($lims_product_data->is_variant) {
                $global_stock = \DB::table('product_warehouse')
                    ->where('product_id', $lims_product_data->id)
                    ->where('variant_id', $parent_variant_id)
                    ->sum('qty') ?? 0;
            } else {
                $global_stock = \DB::table('product_warehouse')
                    ->where('product_id', $lims_product_data->id)
                    ->whereNull('variant_id')
                    ->sum('qty') ?? 0;
            }
        } else {
            $global_stock = $lims_product_data->qty ?? 0;
        }
        $product[] = $global_stock;

        if ($lims_product_data->is_batch != null) {
            $batches = ProductBatch::where('product_id', $lims_product_data->id)
                ->select('id', 'batch_no', 'expired_date', 'qty')
                ->get();

            $product[] = $batches;
        }

        return $product;

    }

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
        foreach ($all_discount as $key => $discount) {
            $product_list = explode(",", $discount->product_list);
            $days = explode(",", $discount->days);

            if (($discount->applicable_for == 'All' || in_array($lims_product_data->id, $product_list)) && ($todayDate >= $discount->valid_from && $todayDate <= $discount->valid_till && in_array(date('D'), $days) && $qty >= $discount->minimum_qty && $qty <= $discount->maximum_qty)) {
                if ($discount->type == 'flat') {
                    $price = $lims_product_data->price - $discount->value;
                } elseif ($discount->type == 'percentage') {
                    $price = $lims_product_data->price - ($lims_product_data->price * ($discount->value / 100));
                }
                $no_discount = 0;
                break;
            } else {
                continue;
            }
        }

        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date && $no_discount) {
            $price = $lims_product_data->promotion_price;
        } elseif ($no_discount)
            $price = $lims_product_data->price;

        $data = [$price, $lims_product_data->promotion];
        return $data;
    }

    public function getGiftCard()
    {
        $gift_card = GiftCard::where("is_active", true)->whereDate('expired_date', '>=', date("Y-m-d"))->get(['id', 'card_no', 'amount', 'expense']);
        return json_encode($gift_card);
    }

    public function productSaleData($id)
    {
        $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
        foreach ($lims_product_sale_data as $key => $product_sale_data) {
            $product = Product::find($product_sale_data->product_id);
            if ($product_sale_data->variant_id) {
                $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_sale_data->product_id, $product_sale_data->variant_id)->first();
                $product->code = $lims_product_variant_data->item_code;
            }
            $unit_data = Unit::find($product_sale_data->sale_unit_id);
            if ($unit_data) {
                $unit = $unit_data->unit_code;
            } else
                $unit = '';
            if ($product_sale_data->product_batch_id) {
                $product_batch_data = ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                $product_sale[7][$key] = $product_batch_data->batch_no;
            } else
                $product_sale[7][$key] = 'N/A';
            $product_sale[0][$key] = $product->name . ' [' . $product->code . ']';
            if ($product_sale_data->imei_number)
                $product_sale[0][$key] .= '<br>IMEI or Serial Number: ' . $product_sale_data->imei_number;
            $product_sale[1][$key] = $product_sale_data->qty;
            $product_sale[2][$key] = $unit;
            $product_sale[3][$key] = $product_sale_data->tax;
            $product_sale[4][$key] = $product_sale_data->tax_rate;
            $product_sale[5][$key] = $product_sale_data->discount;
            $product_sale[6][$key] = $product_sale_data->total;
            $product_sale[8][$key] = $product_sale_data->return_qty;
            $product_sale[9][$key] = $product_sale_data->net_unit_price;
        }
        return $product_sale;
    }

    public function saleByCsv()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-add')) {
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_biller_list = Biller::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $numberOfInvoice = Sale::count();
            return view('backend.sale.import', compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'numberOfInvoice'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function importSale(Request $request)
    {
        //get the file
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        //checking if this is a CSV file
        if ($ext != 'csv')
            return redirect()->back()->with('message', 'Please upload a CSV file');

        $filePath = $upload->getRealPath();
        $file_handle = fopen($filePath, 'r');
        $i = 0;
        //validate the file
        while (!feof($file_handle)) {
            $current_line = fgetcsv($file_handle);
            if ($current_line && $i > 0) {
                $product_data[] = Product::where('code', $current_line[0])->first();
                if (!$product_data[$i - 1])
                    return redirect()->back()->with('message', 'Product does not exist!');
                $unit[] = Unit::where('unit_code', $current_line[2])->first();
                if (!$unit[$i - 1] && $current_line[2] == 'n/a')
                    $unit[$i - 1] = 'n/a';
                elseif (!$unit[$i - 1]) {
                    return redirect()->back()->with('message', 'Sale unit does not exist!');
                }
                if (strtolower($current_line[5]) != "no tax") {
                    $tax[] = Tax::where('name', $current_line[5])->first();
                    if (!$tax[$i - 1])
                        return redirect()->back()->with('message', 'Tax name does not exist!');
                } else
                    $tax[$i - 1]['rate'] = 0;

                $qty[] = $current_line[1];
                $price[] = $current_line[3];
                $discount[] = $current_line[4];
            }
            $i++;
        }
        //return $unit;
        $data = $request->except('document');
        $data['reference_no'] = 'sr-' . date("Ymd") . '-' . date("his");
        $data['user_id'] = Auth::user()->id;
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saleprosaas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move('public/documents/sale', $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move('public/documents/sale', $documentName);
            }
            $data['document'] = $documentName;
        }
        $item = 0;
        $grand_total = $data['shipping_cost'];
        Sale::create($data);
        $lims_sale_data = Sale::latest()->first();
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);

        foreach ($product_data as $key => $product) {
            if ($product['tax_method'] == 1) {
                $net_unit_price = $price[$key] - $discount[$key];
                $product_tax = $net_unit_price * ($tax[$key]['rate'] / 100) * $qty[$key];
                $total = ($net_unit_price * $qty[$key]) + $product_tax;
            } elseif ($product['tax_method'] == 2) {
                $net_unit_price = (100 / (100 + $tax[$key]['rate'])) * ($price[$key] - $discount[$key]);
                $product_tax = ($price[$key] - $discount[$key] - $net_unit_price) * $qty[$key];
                $total = ($price[$key] - $discount[$key]) * $qty[$key];
            }
            if ($data['sale_status'] == 1 && $unit[$key] != 'n/a') {
                $sale_unit_id = $unit[$key]['id'];
                if ($unit[$key]['operator'] == '*')
                    $quantity = $qty[$key] * $unit[$key]['operation_value'];
                elseif ($unit[$key]['operator'] == '/')
                    $quantity = $qty[$key] / $unit[$key]['operation_value'];
                $product['qty'] -= $quantity;
                $product_warehouse = Product_Warehouse::where([
                    ['product_id', $product['id']],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();
                $product_warehouse->qty -= $quantity;
                $product->save();
                $product_warehouse->save();
            } else
                $sale_unit_id = 0;
            //collecting mail data
            $mail_data['products'][$key] = $product['name'];
            if ($product['type'] == 'digital')
                $mail_data['file'][$key] = url('/public/product/files') . '/' . $product['file'];
            else
                $mail_data['file'][$key] = '';
            if ($sale_unit_id)
                $mail_data['unit'][$key] = $unit[$key]['unit_code'];
            else
                $mail_data['unit'][$key] = '';

            $product_sale = new Product_Sale();
            $product_sale->sale_id = $lims_sale_data->id;
            $product_sale->product_id = $product['id'];
            $product_sale->qty = $mail_data['qty'][$key] = $qty[$key];
            $product_sale->sale_unit_id = $sale_unit_id;
            $product_sale->net_unit_price = number_format((float) $net_unit_price, config('decimal'), '.', '');
            $product_sale->discount = $discount[$key] * $qty[$key];
            $product_sale->tax_rate = $tax[$key]['rate'];
            $product_sale->tax = number_format((float) $product_tax, config('decimal'), '.', '');
            $product_sale->total = $mail_data['total'][$key] = number_format((float) $total, config('decimal'), '.', '');
            $product_sale->save();
            $lims_sale_data->total_qty += $qty[$key];
            $lims_sale_data->total_discount += $discount[$key] * $qty[$key];
            $lims_sale_data->total_tax += number_format((float) $product_tax, config('decimal'), '.', '');
            $lims_sale_data->total_price += number_format((float) $total, config('decimal'), '.', '');
        }
        $lims_sale_data->item = $key + 1;
        $lims_sale_data->order_tax = ($lims_sale_data->total_price - $lims_sale_data->order_discount) * ($data['order_tax_rate'] / 100);
        $lims_sale_data->grand_total = ($lims_sale_data->total_price + $lims_sale_data->order_tax + $lims_sale_data->shipping_cost) - $lims_sale_data->order_discount;
        $lims_sale_data->save();
        $message = 'Sale imported successfully';
        $mail_setting = MailSetting::latest()->first();
        if ($lims_customer_data->email && $mail_setting) {
            //collecting male data
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
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new SaleDetails($mail_data));
            } catch (\Exception $e) {
                $message = 'Sale imported successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        return redirect('sales')->with('message', $message);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('sales-edit')) {
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_biller_list = Biller::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_sale_data = Sale::find($id);
            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            if ($lims_sale_data->exchange_rate)
                $currency_exchange_rate = $lims_sale_data->exchange_rate;
            else
                $currency_exchange_rate = 1;
            $custom_fields = CustomField::where('belongs_to', 'sale')->get();
            return view('backend.sale.edit', compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_sale_data', 'lims_product_sale_data', 'currency_exchange_rate', 'custom_fields'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {

        $data = $request->except('document');
        //return dd($data);
        $document = $request->document;
        $lims_sale_data = Sale::find($id);

        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $this->fileDelete('documents/sale/', $lims_sale_data->document);

            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saleprosaas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move('public/documents/sale', $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move('public/documents/sale', $documentName);
            }
            $data['document'] = $documentName;
        }
        $balance = $data['grand_total'] - $data['paid_amount'];
        if ($balance < 0 || $balance > 0)
            $data['payment_status'] = 2;
        else
            $data['payment_status'] = 4;

        DB::beginTransaction();
        try {
            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            $data['created_at'] = date("Y-m-d", strtotime(str_replace("/", "-", $data['created_at'])));
            $product_id = $data['product_id'];
        $imei_number = $data['imei_number'];
        $product_batch_id = $data['product_batch_id'] ?? null;
        $product_code = $data['product_code'];
        $product_variant_id = $data['product_variant_id'];
        $qty = $data['qty'];
        $sale_unit = $data['sale_unit'];
        $net_unit_price = $data['net_unit_price'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $old_product_id = [];
        $product_sale = [];
        foreach ($lims_product_sale_data as $key => $product_sale_data) {
            $old_product_id[] = $product_sale_data->product_id;
            $old_product_variant_id[] = null;
            $lims_product_data = Product::find($product_sale_data->product_id);

            if ($lims_sale_data->isStatus(SaleStatus::COMPLETED) && $lims_product_data->isType(ProductType::COMBO)) {
                $product_list = explode(",", $lims_product_data->product_list);
                $variant_list = explode(",", $lims_product_data->variant_list);
                if ($lims_product_data->variant_list)
                    $variant_list = explode(",", $lims_product_data->variant_list);
                else
                    $variant_list = [];
                $qty_list = explode(",", $lims_product_data->qty_list);

                foreach ($product_list as $index => $child_id) {
                    $child_data = Product::find($child_id);
                    if (count($variant_list) && $variant_list[$index]) {
                        $child_product_variant_data = ProductVariant::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$index]]
                        ])->first();

                        $child_warehouse_data = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$index]],
                            ['warehouse_id', $lims_sale_data->warehouse_id],
                        ])->first();

                        $child_product_variant_data->qty += $product_sale_data->qty * $qty_list[$index];
                        $child_product_variant_data->save();
                    } else {
                        $child_warehouse_data = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['warehouse_id', $lims_sale_data->warehouse_id],
                        ])->first();
                    }

                    $child_data->qty += $product_sale_data->qty * $qty_list[$index];
                    $child_warehouse_data->qty += $product_sale_data->qty * $qty_list[$index];

                    $child_data->save();
                    $child_warehouse_data->save();
                }
            } elseif (($lims_sale_data->sale_status == 1) && ($product_sale_data->sale_unit_id != 0)) {
                $old_product_qty = $product_sale_data->qty;
                $lims_sale_unit_data = Unit::find($product_sale_data->sale_unit_id);
                if ($lims_sale_unit_data->operator == '*')
                    $old_product_qty = $old_product_qty * $lims_sale_unit_data->operation_value;
                else
                    $old_product_qty = $old_product_qty / $lims_sale_unit_data->operation_value;
                if ($product_sale_data->variant_id) {
                    $lims_product_variant_data = ProductVariant::select('id', 'qty')->FindExactProduct($product_sale_data->product_id, $product_sale_data->variant_id)->first();
                    $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($product_sale_data->product_id, $product_sale_data->variant_id, $lims_sale_data->warehouse_id)
                        ->first();
                    $old_product_variant_id[$key] = $lims_product_variant_data->id;
                    $lims_product_variant_data->qty += $old_product_qty;
                    $lims_product_variant_data->save();
                } elseif ($product_sale_data->product_batch_id) {
                    $lims_product_warehouse_data = Product_Warehouse::where([
                        ['product_id', $product_sale_data->product_id],
                        ['product_batch_id', $product_sale_data->product_batch_id],
                        ['warehouse_id', $lims_sale_data->warehouse_id]
                    ])->first();

                    $product_batch_data = ProductBatch::find($product_sale_data->product_batch_id);
                    $product_batch_data->qty += $old_product_qty;
                    $product_batch_data->save();
                } else
                    $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($product_sale_data->product_id, $lims_sale_data->warehouse_id)
                        ->first();
                $lims_product_data->qty += $old_product_qty;
                $lims_product_warehouse_data->qty += $old_product_qty;
                $lims_product_data->save();
                $lims_product_warehouse_data->save();
            }

            if ($product_sale_data->imei_number) {
                if ($lims_product_warehouse_data->imei_number)
                    $lims_product_warehouse_data->imei_number .= ',' . $product_sale_data->imei_number;
                else
                    $lims_product_warehouse_data->imei_number = $product_sale_data->imei_number;
                $lims_product_warehouse_data->save();
            }

            if ($product_sale_data->variant_id && !(in_array($old_product_variant_id[$key], $product_variant_id))) {
                $product_sale_data->delete();
            } elseif (!(in_array($old_product_id[$key], $product_id)))
                $product_sale_data->delete();
        }
        foreach ($product_id as $key => $pro_id) {
            $lims_product_data = Product::find($pro_id);
            $product_sale['variant_id'] = null;
            if ($lims_product_data->isType(ProductType::COMBO) && $data['sale_status'] == SaleStatus::COMPLETED->value) {
                $product_list = explode(",", $lims_product_data->product_list);
                $variant_list = explode(",", $lims_product_data->variant_list);
                if ($lims_product_data->variant_list)
                    $variant_list = explode(",", $lims_product_data->variant_list);
                else
                    $variant_list = [];
                $qty_list = explode(",", $lims_product_data->qty_list);

                foreach ($product_list as $index => $child_id) {
                    $child_data = Product::find($child_id);
                    if (count($variant_list) && $variant_list[$index]) {
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
                        $child_warehouse_data->variant_id = (count($variant_list) && $variant_list[$index]) ? $variant_list[$index] : null;
                        $child_warehouse_data->qty = 0;
                        $child_warehouse_data->price = $child_data->price;
                    }

                    $required_qty = $qty[$key] * $qty_list[$index];
                    if (config('without_stock') == 'no') {
                        if ($child_warehouse_data->qty < $required_qty) {
                            throw new \Exception("The quantity for combo component '{$child_data->name}' exceeds available stock in this warehouse (Available: {$child_warehouse_data->qty}).");
                        }
                        if ($child_product_variant_data && $child_product_variant_data->qty < $required_qty) {
                            throw new \Exception("The quantity for combo component variant '{$child_data->name}' exceeds available stock (Available: {$child_product_variant_data->qty}).");
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
                $sale_unit_id = $lims_sale_unit_data->id;
                if ($data['sale_status'] == 1) {
                    $new_product_qty = $qty[$key];
                    if ($lims_sale_unit_data->operator == '*') {
                        $new_product_qty = $new_product_qty * $lims_sale_unit_data->operation_value;
                    } else {
                        $new_product_qty = $new_product_qty / $lims_sale_unit_data->operation_value;
                    }
                    if ($lims_product_data->is_variant) {
                        $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($pro_id, $product_code[$key])->first();
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($pro_id, $lims_product_variant_data->variant_id, $data['warehouse_id'])
                            ->first();

                        $product_sale['variant_id'] = $lims_product_variant_data->variant_id;
                    } elseif ($product_batch_id[$key]) {
                        $lims_product_warehouse_data = Product_Warehouse::where([
                            ['product_id', $pro_id],
                            ['product_batch_id', $product_batch_id[$key]],
                            ['warehouse_id', $data['warehouse_id']]
                        ])->first();

                        $product_batch_data = ProductBatch::find($product_batch_id[$key]);
                    } else {
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($pro_id, $data['warehouse_id'])
                            ->first();
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
                            throw new \Exception("The quantity for product '{$lims_product_data->name}' exceeds available stock in this warehouse (Available: {$lims_product_warehouse_data->qty}).");
                        }
                        if ($lims_product_data->is_variant && $lims_product_variant_data->qty < $new_product_qty) {
                            throw new \Exception("The quantity for product variant '{$lims_product_data->name}' exceeds available stock (Available: {$lims_product_variant_data->qty}).");
                        }
                        if ($product_batch_id[$key] && $product_batch_data->qty < $new_product_qty) {
                            throw new \Exception("The quantity for product batch '{$lims_product_data->name}' exceeds available stock (Available: {$product_batch_data->qty}).");
                        }
                    }

                    if ($lims_product_data->is_variant) {
                        $lims_product_variant_data->qty -= $new_product_qty;
                        $lims_product_variant_data->save();
                    } elseif ($product_batch_id[$key]) {
                        $product_batch_data->qty -= $new_product_qty;
                        $product_batch_data->save();
                    }
                    $lims_product_data->qty -= $new_product_qty;
                    $lims_product_warehouse_data->qty -= $new_product_qty;
                    $lims_product_data->save();
                    $lims_product_warehouse_data->save();
                }
            } else
                $sale_unit_id = 0;

            //deduct imei number if available
            if ($imei_number[$key]) {
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

            //collecting mail data
            if ($product_sale['variant_id']) {
                $variant_data = Variant::select('name')->find($product_sale['variant_id']);
                $mail_data['products'][$key] = $lims_product_data->name . ' [' . $variant_data->name . ']';
            } else
                $mail_data['products'][$key] = $lims_product_data->name;

            if ($lims_product_data->type == 'digital')
                $mail_data['file'][$key] = url('/public/product/files') . '/' . $lims_product_data->file;
            else
                $mail_data['file'][$key] = '';
            if ($sale_unit_id)
                $mail_data['unit'][$key] = $lims_sale_unit_data->unit_code;
            else
                $mail_data['unit'][$key] = '';

            $product_sale['sale_id'] = $id;
            $product_sale['product_id'] = $pro_id;
            $product_sale['imei_number'] = $imei_number[$key];
            // $product_sale['product_batch_id'] = $product_batch_id[$key];
            $product_sale['qty'] = $mail_data['qty'][$key] = $qty[$key];
            $product_sale['sale_unit_id'] = $sale_unit_id;
            $product_sale['net_unit_price'] = $net_unit_price[$key];
            $product_sale['discount'] = $discount[$key];
            $product_sale['tax_rate'] = $tax_rate[$key];
            $product_sale['tax'] = $tax[$key];
            $product_sale['total'] = $mail_data['total'][$key] = $total[$key];

            if ($product_sale['variant_id'] && in_array($product_variant_id[$key], $old_product_variant_id)) {
                Product_Sale::where([
                    ['product_id', $pro_id],
                    ['variant_id', $product_sale['variant_id']],
                    ['sale_id', $id]
                ])->update($product_sale);
            } elseif ($product_sale['variant_id'] === null && (in_array($pro_id, $old_product_id))) {
                Product_Sale::where([
                    ['sale_id', $id],
                    ['product_id', $pro_id]
                ])->update($product_sale);
            } else
                Product_Sale::create($product_sale);
        }

        $lims_sale_data->update($data);
        //inserting data for custom fields
        $custom_field_data = [];
        $custom_fields = CustomField::where('belongs_to', 'sale')->select('name', 'type')->get();
        foreach ($custom_fields as $type => $custom_field) {
            $field_name = str_replace(' ', '_', strtolower($custom_field->name));
            if (isset($data[$field_name])) {
                if ($custom_field->type == 'checkbox' || $custom_field->type == 'multi_select')
                    $custom_field_data[$field_name] = implode(",", $data[$field_name]);
                else
                    $custom_field_data[$field_name] = $data[$field_name];
            }
        }
        if (count($custom_field_data))
            DB::table('sales')->where('id', $lims_sale_data->id)->update($custom_field_data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        $lims_customer_data = Customer::find($data['customer_id']);
        $message = 'Sale updated successfully';
        //collecting mail data
        $mail_setting = MailSetting::latest()->first();
        if ($lims_customer_data->email && $mail_setting) {
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
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new SaleDetails($mail_data));
            } catch (\Exception $e) {
                $message = 'Sale updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }

        return redirect('sales')->with('message', $message);
    }

    public function printLastReciept()
    {
        $sale = Sale::where('sale_status', 1)->latest()->first();
        return redirect()->route('sale.invoice', $sale->id);
    }

    public function genInvoice($id)
    {


        $lims_sale_data = Sale::find($id);
        $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
        if (cache()->has('biller_list')) {
            $lims_biller_data = cache()->get('biller_list')->find($lims_sale_data->biller_id);
        } else {
            $lims_biller_data = Biller::find($lims_sale_data->biller_id);
        }
        if (cache()->has('warehouse_list')) {
            $lims_warehouse_data = cache()->get('warehouse_list')->find($lims_sale_data->warehouse_id);
        } else {
            $lims_warehouse_data = Warehouse::find($lims_sale_data->warehouse_id);
        }

        if (cache()->has('customer_list')) {
            $lims_customer_data = cache()->get('customer_list')->find($lims_sale_data->customer_id);
        } else {
            $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        }

        $lims_payment_data = Payment::where('sale_id', $id)->get();
        if (cache()->has('pos_setting')) {
            $lims_pos_setting_data = cache()->get('pos_setting');
        } else {
            $lims_pos_setting_data = PosSetting::select('invoice_option')->latest()->first();
        }

        $supportedIdentifiers = [
            'al',
            'fr_BE',
            'pt_BR',
            'bg',
            'cs',
            'dk',
            'nl',
            'et',
            'ka',
            'de',
            'fr',
            'hu',
            'id',
            'it',
            'lt',
            'lv',
            'ms',
            'fa',
            'pl',
            'ro',
            'sk',
            'es',
            'ru',
            'sv',
            'tr',
            'tk',
            'ua',
            'yo'
        ]; //ar, az, ku, mk - not supported

        $defaultLocale = App::getLocale();
        $numberToWords = new NumberToWords();

        if (in_array($defaultLocale, $supportedIdentifiers))
            $numberTransformer = $numberToWords->getNumberTransformer($defaultLocale);
        else
            $numberTransformer = $numberToWords->getNumberTransformer('en');
        if (is_null($lims_sale_data->exchange_rate)) {
            $numberInWords = $numberTransformer->toWords($lims_sale_data->grand_total);
            $currency_code = cache()->get('currency')->code;
        } else {
            $numberInWords = $numberTransformer->toWords($lims_sale_data->grand_total);
            $sale_currency = DB::table('currencies')->select('code')->where('id', $lims_sale_data->currency_id)->first();
            $currency_code = $sale_currency->code;
        }
         $qrText = $lims_sale_data->reference_no;
        $paying_methods = Payment::where('sale_id', $id)->pluck('paying_method')->toArray();
        $paid_by_info = '';
        foreach ($paying_methods as $key => $paying_method) {
            if ($key)
                $paid_by_info .= ', ' . $paying_method;
            else
                $paid_by_info = $paying_method;
        }

        // Generate ZATCA QR code securely with fallbacks
        $qrText = $lims_sale_data->reference_no;
        if (class_exists('Salla\ZATCA\GenerateQrCode')) {
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
        if ($lims_pos_setting_data->invoice_option == 'A4') {
            return view('backend.sale.a4_invoice', compact('lims_sale_data', 'currency_code', 'lims_product_sale_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'numberInWords', 'paid_by_info', 'sale_custom_fields', 'customer_custom_fields', 'product_custom_fields' ,'qrText'));
        } else {
            return view('backend.sale.invoice', compact('lims_sale_data', 'currency_code', 'lims_product_sale_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'numberInWords', 'sale_custom_fields', 'customer_custom_fields', 'product_custom_fields' ,'qrText'));
        }
    }

    public function addPayment(Request $request)
    {
        $data = $request->all();
        if (!$data['amount'])
            $data['amount'] = 0.00;

        $lims_sale_data = Sale::find($data['sale_id']);
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        $lims_sale_data->paid_amount += $data['amount'];
        $balance = $lims_sale_data->grand_total - $lims_sale_data->paid_amount;
        if ($balance > 0 || $balance < 0)
            $lims_sale_data->payment_status = 2;
        elseif ($balance == 0)
            $lims_sale_data->payment_status = 4;

        if ($data['paid_by_id'] == 1)
            $paying_method = 'Cash';
        elseif ($data['paid_by_id'] == 2)
            $paying_method = 'Gift Card';
        elseif ($data['paid_by_id'] == 3)
            $paying_method = 'Credit Card';
        elseif ($data['paid_by_id'] == 4)
            $paying_method = 'Cheque';
        elseif ($data['paid_by_id'] == 5)
            $paying_method = 'Paypal';
        elseif ($data['paid_by_id'] == 6)
            $paying_method = 'Deposit';
        elseif ($data['paid_by_id'] == 7)
            $paying_method = 'Points';


        $cash_register_data = CashRegister::where([
            ['user_id', Auth::id()],
            ['warehouse_id', $lims_sale_data->warehouse_id],
            ['status', true]
        ])->first();

        $lims_payment_data = new Payment();
        $lims_payment_data->user_id = Auth::id();
        $lims_payment_data->sale_id = $lims_sale_data->id;
        if ($cash_register_data)
            $lims_payment_data->cash_register_id = $cash_register_data->id;
        $lims_payment_data->account_id = $data['account_id'];
        $data['payment_reference'] = 'spr-' . date("Ymd") . '-' . date("his");
        $lims_payment_data->payment_reference = $data['payment_reference'];
        $lims_payment_data->amount = $data['amount'];
        $lims_payment_data->change = $data['paying_amount'] - $data['amount'];
        $lims_payment_data->paying_method = $paying_method;
        $lims_payment_data->payment_note = $data['payment_note'];
        $lims_payment_data->due_payment = 1;
        $lims_payment_data->save();
        $lims_sale_data->save();

        $lims_payment_data = Payment::latest()->first();
        $data['payment_id'] = $lims_payment_data->id;

        if ($paying_method == 'Gift Card') {
            $lims_gift_card_data = GiftCard::find($data['gift_card_id']);
            $lims_gift_card_data->expense += $data['amount'];
            $lims_gift_card_data->save();
            PaymentWithGiftCard::create($data);
        } elseif ($paying_method == 'Credit Card') {
            $lims_pos_setting_data = PosSetting::latest()->first();
            Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
            $token = $data['stripeToken'];
            $amount = $data['amount'];

            $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('customer_id', $lims_sale_data->customer_id)->first();

            if (!$lims_payment_with_credit_card_data) {
                // Create a Customer:
                $customer = \Stripe\Customer::create([
                    'source' => $token
                ]);

                // Charge the Customer instead of the card:
                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $customer->id,
                ]);
                $data['customer_stripe_id'] = $customer->id;
            } else {
                $customer_id =
                    $lims_payment_with_credit_card_data->customer_stripe_id;

                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $customer_id, // Previously stored, then retrieved
                ]);
                $data['customer_stripe_id'] = $customer_id;
            }
            $data['customer_id'] = $lims_sale_data->customer_id;
            $data['charge_id'] = $charge->id;
            PaymentWithCreditCard::create($data);
        } elseif ($paying_method == 'Cheque') {
            PaymentWithCheque::create($data);
        } elseif ($paying_method == 'Paypal') {
            $provider = new ExpressCheckout;
            $paypal_data['items'] = [];
            $paypal_data['items'][] = [
                'name' => 'Paid Amount',
                'price' => $data['amount'],
                'qty' => 1
            ];
            $paypal_data['invoice_id'] = $lims_payment_data->payment_reference;
            $paypal_data['invoice_description'] = "Reference: {$paypal_data['invoice_id']}";
            $paypal_data['return_url'] = url('/sale/paypalPaymentSuccess/' . $lims_payment_data->id);
            $paypal_data['cancel_url'] = url('/sale');

            $total = 0;
            foreach ($paypal_data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $paypal_data['total'] = $total;
            $response = $provider->setExpressCheckout($paypal_data);
            return redirect($response['paypal_link']);
        } elseif ($paying_method == 'Deposit') {
            $lims_customer_data->expense += $data['amount'];
            $lims_customer_data->save();
        } elseif ($paying_method == 'Points') {
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            $used_points = ceil($data['amount'] / $lims_reward_point_setting_data->per_point_amount);

            $lims_payment_data->used_points = $used_points;
            $lims_payment_data->save();

            $lims_customer_data->points -= $used_points;
            $lims_customer_data->save();
        }
        $message = 'Payment created successfully';
        $mail_setting = MailSetting::latest()->first();
        if ($lims_customer_data->email && $mail_setting) {
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['sale_reference'] = $lims_sale_data->reference_no;
            $mail_data['payment_reference'] = $lims_payment_data->payment_reference;
            $mail_data['payment_method'] = $lims_payment_data->paying_method;
            $mail_data['grand_total'] = $lims_sale_data->grand_total;
            $mail_data['paid_amount'] = $lims_payment_data->amount;
            $mail_data['currency'] = config('currency');
            $mail_data['due'] = $balance;
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new PaymentDetails($mail_data));
            } catch (\Exception $e) {
                $message = 'Payment created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }

        }
        return redirect('sales')->with('message', $message);
    }

    public function getPayment($id)
    {
        $lims_payment_list = Payment::where('sale_id', $id)->get();
        $date = [];
        $payment_reference = [];
        $paid_amount = [];
        $paying_method = [];
        $payment_id = [];
        $payment_note = [];
        $gift_card_id = [];
        $cheque_no = [];
        $change = [];
        $paying_amount = [];
        $account_name = [];
        $account_id = [];

        foreach ($lims_payment_list as $payment) {
            $date[] = date(config('date_format'), strtotime($payment->created_at->toDateString())) . ' ' . $payment->created_at->toTimeString();
            $payment_reference[] = $payment->payment_reference;
            $paid_amount[] = $payment->amount;
            $change[] = $payment->change;
            $paying_method[] = $payment->paying_method;
            $paying_amount[] = $payment->amount + $payment->change;
            if ($payment->paying_method == 'Gift Card') {
                $lims_payment_gift_card_data = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                $gift_card_id[] = $lims_payment_gift_card_data->gift_card_id;
            } elseif ($payment->paying_method == 'Cheque') {
                $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $payment->id)->first();
                $cheque_no[] = $lims_payment_cheque_data->cheque_no;
            } else {
                $cheque_no[] = $gift_card_id[] = null;
            }
            $payment_id[] = $payment->id;
            $payment_note[] = $payment->payment_note;
            $lims_account_data = Account::find($payment->account_id);
            $account_name[] = $lims_account_data->name;
            $account_id[] = $lims_account_data->id;
        }
        $payments[] = $date;
        $payments[] = $payment_reference;
        $payments[] = $paid_amount;
        $payments[] = $paying_method;
        $payments[] = $payment_id;
        $payments[] = $payment_note;
        $payments[] = $cheque_no;
        $payments[] = $gift_card_id;
        $payments[] = $change;
        $payments[] = $paying_amount;
        $payments[] = $account_name;
        $payments[] = $account_id;

        return $payments;
    }

    public function updatePayment(Request $request)
    {
        $data = $request->all();
        //return $data;
        $lims_payment_data = Payment::find($data['payment_id']);
        $lims_sale_data = Sale::find($lims_payment_data->sale_id);
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        //updating sale table
        $amount_dif = $lims_payment_data->amount - $data['edit_amount'];
        $lims_sale_data->paid_amount = $lims_sale_data->paid_amount - $amount_dif;
        $balance = $lims_sale_data->grand_total - $lims_sale_data->paid_amount;
        if ($balance > 0 || $balance < 0)
            $lims_sale_data->payment_status = 2;
        elseif ($balance == 0)
            $lims_sale_data->payment_status = 4;
        $lims_sale_data->save();

        if ($lims_payment_data->paying_method == 'Deposit') {
            $lims_customer_data->expense -= $lims_payment_data->amount;
            $lims_customer_data->save();
        } elseif ($lims_payment_data->paying_method == 'Points') {
            $lims_customer_data->points += $lims_payment_data->used_points;
            $lims_customer_data->save();
            $lims_payment_data->used_points = 0;
        }
        if ($data['edit_paid_by_id'] == 1)
            $lims_payment_data->paying_method = 'Cash';
        elseif ($data['edit_paid_by_id'] == 2) {
            if ($lims_payment_data->paying_method == 'Gift Card') {
                $lims_payment_gift_card_data = PaymentWithGiftCard::where('payment_id', $data['payment_id'])->first();

                $lims_gift_card_data = GiftCard::find($lims_payment_gift_card_data->gift_card_id);
                $lims_gift_card_data->expense -= $lims_payment_data->amount;
                $lims_gift_card_data->save();

                $lims_gift_card_data = GiftCard::find($data['gift_card_id']);
                $lims_gift_card_data->expense += $data['edit_amount'];
                $lims_gift_card_data->save();

                $lims_payment_gift_card_data->gift_card_id = $data['gift_card_id'];
                $lims_payment_gift_card_data->save();
            } else {
                $lims_payment_data->paying_method = 'Gift Card';
                $lims_gift_card_data = GiftCard::find($data['gift_card_id']);
                $lims_gift_card_data->expense += $data['edit_amount'];
                $lims_gift_card_data->save();
                PaymentWithGiftCard::create($data);
            }
        } elseif ($data['edit_paid_by_id'] == 3) {
            $lims_pos_setting_data = PosSetting::latest()->first();
            Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
            if ($lims_payment_data->paying_method == 'Credit Card') {
                $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $lims_payment_data->id)->first();

                \Stripe\Refund::create(array(
                    "charge" => $lims_payment_with_credit_card_data->charge_id,
                ));

                $customer_id =
                    $lims_payment_with_credit_card_data->customer_stripe_id;

                $charge = \Stripe\Charge::create([
                    'amount' => $data['edit_amount'] * 100,
                    'currency' => 'usd',
                    'customer' => $customer_id
                ]);
                $lims_payment_with_credit_card_data->charge_id = $charge->id;
                $lims_payment_with_credit_card_data->save();
            } else {
                $token = $data['stripeToken'];
                $amount = $data['edit_amount'];
                $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('customer_id', $lims_sale_data->customer_id)->first();

                if (!$lims_payment_with_credit_card_data) {
                    $customer = \Stripe\Customer::create([
                        'source' => $token
                    ]);

                    $charge = \Stripe\Charge::create([
                        'amount' => $amount * 100,
                        'currency' => 'usd',
                        'customer' => $customer->id,
                    ]);
                    $data['customer_stripe_id'] = $customer->id;
                } else {
                    $customer_id =
                        $lims_payment_with_credit_card_data->customer_stripe_id;

                    $charge = \Stripe\Charge::create([
                        'amount' => $amount * 100,
                        'currency' => 'usd',
                        'customer' => $customer_id
                    ]);
                    $data['customer_stripe_id'] = $customer_id;
                }
                $data['customer_id'] = $lims_sale_data->customer_id;
                $data['charge_id'] = $charge->id;
                PaymentWithCreditCard::create($data);
            }
            $lims_payment_data->paying_method = 'Credit Card';
        } elseif ($data['edit_paid_by_id'] == 4) {
            if ($lims_payment_data->paying_method == 'Cheque') {
                $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $data['payment_id'])->first();
                $lims_payment_cheque_data->cheque_no = $data['edit_cheque_no'];
                $lims_payment_cheque_data->save();
            } else {
                $lims_payment_data->paying_method = 'Cheque';
                $data['cheque_no'] = $data['edit_cheque_no'];
                PaymentWithCheque::create($data);
            }
        } elseif ($data['edit_paid_by_id'] == 5) {
            //updating payment data
            $lims_payment_data->amount = $data['edit_amount'];
            $lims_payment_data->paying_method = 'Paypal';
            $lims_payment_data->payment_note = $data['edit_payment_note'];
            $lims_payment_data->save();

            $provider = new ExpressCheckout;
            $paypal_data['items'] = [];
            $paypal_data['items'][] = [
                'name' => 'Paid Amount',
                'price' => $data['edit_amount'],
                'qty' => 1
            ];
            $paypal_data['invoice_id'] = $lims_payment_data->payment_reference;
            $paypal_data['invoice_description'] = "Reference: {$paypal_data['invoice_id']}";
            $paypal_data['return_url'] = url('/sale/paypalPaymentSuccess/' . $lims_payment_data->id);
            $paypal_data['cancel_url'] = url('/sale');

            $total = 0;
            foreach ($paypal_data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $paypal_data['total'] = $total;
            $response = $provider->setExpressCheckout($paypal_data);
            return redirect($response['paypal_link']);
        } elseif ($data['edit_paid_by_id'] == 6) {
            $lims_payment_data->paying_method = 'Deposit';
            $lims_customer_data->expense += $data['edit_amount'];
            $lims_customer_data->save();
        } elseif ($data['edit_paid_by_id'] == 7) {
            $lims_payment_data->paying_method = 'Points';
            $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
            $used_points = ceil($data['edit_amount'] / $lims_reward_point_setting_data->per_point_amount);
            $lims_payment_data->used_points = $used_points;
            $lims_customer_data->points -= $used_points;
            $lims_customer_data->save();
        }
        //updating payment data
        $lims_payment_data->account_id = $data['account_id'];
        $lims_payment_data->amount = $data['edit_amount'];
        $lims_payment_data->change = $data['edit_paying_amount'] - $data['edit_amount'];
        $lims_payment_data->payment_note = $data['edit_payment_note'];
        $lims_payment_data->save();
        $message = 'Payment updated successfully';
        //collecting male data
        $mail_setting = MailSetting::latest()->first();
        if ($lims_customer_data->email && $mail_setting) {
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['sale_reference'] = $lims_sale_data->reference_no;
            $mail_data['payment_reference'] = $lims_payment_data->payment_reference;
            $mail_data['payment_method'] = $lims_payment_data->paying_method;
            $mail_data['grand_total'] = $lims_sale_data->grand_total;
            $mail_data['paid_amount'] = $lims_payment_data->amount;
            $mail_data['currency'] = config('currency');
            $mail_data['due'] = $balance;
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new PaymentDetails($mail_data));
            } catch (\Exception $e) {
                $message = 'Payment updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        return redirect('sales')->with('message', $message);
    }

    public function deletePayment(Request $request)
    {
        $lims_payment_data = Payment::find($request['id']);
        $lims_sale_data = Sale::where('id', $lims_payment_data->sale_id)->first();
        $lims_sale_data->paid_amount -= $lims_payment_data->amount;
        $balance = $lims_sale_data->grand_total - $lims_sale_data->paid_amount;
        if ($balance > 0 || $balance < 0)
            $lims_sale_data->payment_status = 2;
        elseif ($balance == 0)
            $lims_sale_data->payment_status = 4;
        $lims_sale_data->save();

        if ($lims_payment_data->paying_method == 'Gift Card') {
            $lims_payment_gift_card_data = PaymentWithGiftCard::where('payment_id', $request['id'])->first();
            $lims_gift_card_data = GiftCard::find($lims_payment_gift_card_data->gift_card_id);
            $lims_gift_card_data->expense -= $lims_payment_data->amount;
            $lims_gift_card_data->save();
            $lims_payment_gift_card_data->delete();
        } elseif ($lims_payment_data->paying_method == 'Credit Card') {
            $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $request['id'])->first();
            $lims_pos_setting_data = PosSetting::latest()->first();
            Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
            \Stripe\Refund::create(array(
                "charge" => $lims_payment_with_credit_card_data->charge_id,
            ));

            $lims_payment_with_credit_card_data->delete();
        } elseif ($lims_payment_data->paying_method == 'Cheque') {
            $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $request['id'])->first();
            $lims_payment_cheque_data->delete();
        } elseif ($lims_payment_data->paying_method == 'Paypal') {
            $lims_payment_paypal_data = PaymentWithPaypal::where('payment_id', $request['id'])->first();
            if ($lims_payment_paypal_data) {
                $provider = new ExpressCheckout;
                $response = $provider->refundTransaction($lims_payment_paypal_data->transaction_id);
                $lims_payment_paypal_data->delete();
            }
        } elseif ($lims_payment_data->paying_method == 'Deposit') {
            $lims_customer_data = Customer::find($lims_sale_data->customer_id);
            $lims_customer_data->expense -= $lims_payment_data->amount;
            $lims_customer_data->save();
        } elseif ($lims_payment_data->paying_method == 'Points') {
            $lims_customer_data = Customer::find($lims_sale_data->customer_id);
            $lims_customer_data->points += $lims_payment_data->used_points;
            $lims_customer_data->save();
        }
        $lims_payment_data->delete();
        return redirect('sales')->with('not_permitted', 'Payment deleted successfully');
    }

    public function todaySale()
    {
        $data['total_sale_amount'] = Sale::whereDate('created_at', date("Y-m-d"))->sum('grand_total');
        $data['total_payment'] = Payment::whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['cash_payment'] = Payment::where([
            ['paying_method', 'Cash']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['credit_card_payment'] = Payment::where([
            ['paying_method', 'Credit Card']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['gift_card_payment'] = Payment::where([
            ['paying_method', 'Gift Card']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['deposit_payment'] = Payment::where([
            ['paying_method', 'Deposit']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['cheque_payment'] = Payment::where([
            ['paying_method', 'Cheque']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['paypal_payment'] = Payment::where([
            ['paying_method', 'Paypal']
        ])->whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['total_sale_return'] = Returns::whereDate('created_at', date("Y-m-d"))->sum('grand_total');
        $data['total_expense'] = Expense::whereDate('created_at', date("Y-m-d"))->sum('amount');
        $data['total_cash'] = $data['total_payment'] - ($data['total_sale_return'] + $data['total_expense']);
        return $data;
    }

    public function todayProfit($warehouse_id)
    {
        if ($warehouse_id == 0)
            $product_sale_data = Product_Sale::select(DB::raw('product_id, product_batch_id, sum(qty) as sold_qty, sum(total) as sold_amount'))->whereDate('created_at', date("Y-m-d"))->groupBy('product_id', 'product_batch_id')->get();
        else
            $product_sale_data = Sale::join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                ->select(DB::raw('product_sales.product_id, product_sales.product_batch_id, sum(product_sales.qty) as sold_qty, sum(product_sales.total) as sold_amount'))
                ->where('sales.warehouse_id', $warehouse_id)->whereDate('sales.created_at', date("Y-m-d"))
                ->groupBy('product_sales.product_id', 'product_sales.product_batch_id')->get();

        $product_revenue = 0;
        $product_cost = 0;
        $profit = 0;
        foreach ($product_sale_data as $key => $product_sale) {
            if ($warehouse_id == 0) {
                if ($product_sale->product_batch_id)
                    $product_purchase_data = ProductPurchase::where([
                        ['product_id', $product_sale->product_id],
                        ['product_batch_id', $product_sale->product_batch_id]
                    ])->get();
                else
                    $product_purchase_data = ProductPurchase::where('product_id', $product_sale->product_id)->get();
            } else {
                if ($product_sale->product_batch_id) {
                    $product_purchase_data = Purchase::join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')
                        ->where([
                            ['product_purchases.product_id', $product_sale->product_id],
                            ['product_purchases.product_batch_id', $product_sale->product_batch_id],
                            ['purchases.warehouse_id', $warehouse_id]
                        ])->select('product_purchases.*')->get();
                } else
                    $product_purchase_data = Purchase::join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')
                        ->where([
                            ['product_purchases.product_id', $product_sale->product_id],
                            ['purchases.warehouse_id', $warehouse_id]
                        ])->select('product_purchases.*')->get();
            }

            $purchased_qty = 0;
            $purchased_amount = 0;
            $sold_qty = $product_sale->sold_qty;
            $product_revenue += $product_sale->sold_amount;
            foreach ($product_purchase_data as $key => $product_purchase) {
                $purchased_qty += $product_purchase->qty;
                $purchased_amount += $product_purchase->total;
                if ($purchased_qty >= $sold_qty) {
                    $qty_diff = $purchased_qty - $sold_qty;
                    $unit_cost = $product_purchase->total / $product_purchase->qty;
                    $purchased_amount -= ($qty_diff * $unit_cost);
                    break;
                }
            }

            $product_cost += $purchased_amount;
            $profit += $product_sale->sold_amount - $purchased_amount;
        }

        $data['product_revenue'] = $product_revenue;
        $data['product_cost'] = $product_cost;
        if ($warehouse_id == 0)
            $data['expense_amount'] = Expense::whereDate('created_at', date("Y-m-d"))->sum('amount');
        else
            $data['expense_amount'] = Expense::where('warehouse_id', $warehouse_id)->whereDate('created_at', date("Y-m-d"))->sum('amount');

        $data['profit'] = $profit - $data['expense_amount'];
        return $data;
    }

    public function deleteBySelection(Request $request)
    {
        $sale_id = $request['saleIdArray'];
        foreach ($sale_id as $id) {
            $lims_sale_data = Sale::find($id);
            $return_ids = Returns::where('sale_id', $id)->pluck('id')->toArray();
            if (count($return_ids)) {
                ProductReturn::whereIn('return_id', $return_ids)->delete();
                Returns::whereIn('id', $return_ids)->delete();
            }
            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            $lims_delivery_data = Delivery::where('sale_id', $id)->first();
            if ($lims_sale_data->sale_status == 3)
                $message = 'Draft deleted successfully';
            else
                $message = 'Sale deleted successfully';
            foreach ($lims_product_sale_data as $product_sale) {
                $lims_product_data = Product::find($product_sale->product_id);
                //adjust product quantity
                if ($lims_sale_data->isStatus(SaleStatus::COMPLETED) && $lims_product_data->isType(ProductType::COMBO)) {
                    $product_list = explode(",", $lims_product_data->product_list);
                    if ($lims_product_data->variant_list)
                        $variant_list = explode(",", $lims_product_data->variant_list);
                    else
                        $variant_list = [];
                    $qty_list = explode(",", $lims_product_data->qty_list);

                    foreach ($product_list as $index => $child_id) {
                        $child_data = Product::find($child_id);
                        if (count($variant_list) && $variant_list[$index]) {
                            $child_product_variant_data = ProductVariant::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]]
                            ])->first();

                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['variant_id', $variant_list[$index]],
                                ['warehouse_id', $lims_sale_data->warehouse_id],
                            ])->first();

                            $child_product_variant_data->qty += $product_sale->qty * $qty_list[$index];
                            $child_product_variant_data->save();
                        } else {
                            $child_warehouse_data = Product_Warehouse::where([
                                ['product_id', $child_id],
                                ['warehouse_id', $lims_sale_data->warehouse_id],
                            ])->first();
                        }

                        $child_data->qty += $product_sale->qty * $qty_list[$index];
                        $child_warehouse_data->qty += $product_sale->qty * $qty_list[$index];

                        $child_data->save();
                        $child_warehouse_data->save();
                    }
                } elseif (($lims_sale_data->sale_status == 1) && ($product_sale->sale_unit_id != 0)) {
                    $lims_sale_unit_data = Unit::find($product_sale->sale_unit_id);
                    if ($lims_sale_unit_data->operator == '*')
                        $product_sale->qty = $product_sale->qty * $lims_sale_unit_data->operation_value;
                    else
                        $product_sale->qty = $product_sale->qty / $lims_sale_unit_data->operation_value;
                    if ($product_sale->variant_id) {
                        $lims_product_variant_data = ProductVariant::select('id', 'qty')->FindExactProduct($lims_product_data->id, $product_sale->variant_id)->first();
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($lims_product_data->id, $product_sale->variant_id, $lims_sale_data->warehouse_id)->first();
                        $lims_product_variant_data->qty += $product_sale->qty;
                        $lims_product_variant_data->save();
                    } elseif ($product_sale->product_batch_id) {
                        $lims_product_batch_data = ProductBatch::find($product_sale->product_batch_id);
                        $lims_product_warehouse_data = Product_Warehouse::where([
                            ['product_batch_id', $product_sale->product_batch_id],
                            ['warehouse_id', $lims_sale_data->warehouse_id]
                        ])->first();

                        $lims_product_batch_data->qty -= $product_sale->qty;
                        $lims_product_batch_data->save();
                    } else {
                        $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($lims_product_data->id, $lims_sale_data->warehouse_id)->first();
                    }

                    $lims_product_data->qty += $product_sale->qty;
                    $lims_product_warehouse_data->qty += $product_sale->qty;
                    $lims_product_data->save();
                    $lims_product_warehouse_data->save();
                }
                $product_sale->delete();
            }
            $lims_payment_data = Payment::where('sale_id', $id)->get();
            foreach ($lims_payment_data as $payment) {
                if ($payment->paying_method == 'Gift Card') {
                    $lims_payment_with_gift_card_data = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                    $lims_gift_card_data = GiftCard::find($lims_payment_with_gift_card_data->gift_card_id);
                    $lims_gift_card_data->expense -= $payment->amount;
                    $lims_gift_card_data->save();
                    $lims_payment_with_gift_card_data->delete();
                } elseif ($payment->paying_method == 'Cheque') {
                    $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $payment->id)->first();
                    $lims_payment_cheque_data->delete();
                } elseif ($payment->paying_method == 'Credit Card') {
                    $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $payment->id)->first();
                    $lims_payment_with_credit_card_data->delete();
                } elseif ($payment->paying_method == 'Paypal') {
                    $lims_payment_paypal_data = PaymentWithPaypal::where('payment_id', $payment->id)->first();
                    if ($lims_payment_paypal_data)
                        $lims_payment_paypal_data->delete();
                } elseif ($payment->paying_method == 'Deposit') {
                    $lims_customer_data = Customer::find($lims_sale_data->customer_id);
                    $lims_customer_data->expense -= $payment->amount;
                    $lims_customer_data->save();
                }
                $payment->delete();
            }
            if ($lims_delivery_data)
                $lims_delivery_data->delete();
            if ($lims_sale_data->coupon_id) {
                $lims_coupon_data = Coupon::find($lims_sale_data->coupon_id);
                $lims_coupon_data->used -= 1;
                $lims_coupon_data->save();
            }
            $lims_sale_data->delete();
            $this->fileDelete('documents/sale/', $lims_sale_data->document);

        }
        return 'Sale deleted successfully!';
    }

    public function destroy($id)
    {
        $url = url()->previous();
        $lims_sale_data = Sale::find($id);
        $return_ids = Returns::where('sale_id', $id)->pluck('id')->toArray();
        if (count($return_ids)) {
            ProductReturn::whereIn('return_id', $return_ids)->delete();
            Returns::whereIn('id', $return_ids)->delete();
        }
        $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
        $lims_delivery_data = Delivery::where('sale_id', $id)->first();
        if ($lims_sale_data->sale_status == 3)
            $message = 'Draft deleted successfully';
        else
            $message = 'Sale deleted successfully';

        foreach ($lims_product_sale_data as $product_sale) {
            $lims_product_data = Product::find($product_sale->product_id);
            //adjust product quantity
            if ($lims_sale_data->isStatus(SaleStatus::COMPLETED) && $lims_product_data->isType(ProductType::COMBO)) {
                $product_list = explode(",", $lims_product_data->product_list);
                $variant_list = explode(",", $lims_product_data->variant_list);
                $qty_list = explode(",", $lims_product_data->qty_list);
                if ($lims_product_data->variant_list)
                    $variant_list = explode(",", $lims_product_data->variant_list);
                else
                    $variant_list = [];
                foreach ($product_list as $index => $child_id) {
                    $child_data = Product::find($child_id);
                    if (count($variant_list) && $variant_list[$index]) {
                        $child_product_variant_data = ProductVariant::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$index]]
                        ])->first();

                        $child_warehouse_data = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$index]],
                            ['warehouse_id', $lims_sale_data->warehouse_id],
                        ])->first();

                        $child_product_variant_data->qty += $product_sale->qty * $qty_list[$index];
                        $child_product_variant_data->save();
                    } else {
                        $child_warehouse_data = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['warehouse_id', $lims_sale_data->warehouse_id],
                        ])->first();
                    }

                    $child_data->qty += $product_sale->qty * $qty_list[$index];
                    $child_warehouse_data->qty += $product_sale->qty * $qty_list[$index];

                    $child_data->save();
                    $child_warehouse_data->save();
                }
            } elseif (($lims_sale_data->sale_status == 1) && ($product_sale->sale_unit_id != 0)) {
                $lims_sale_unit_data = Unit::find($product_sale->sale_unit_id);
                if ($lims_sale_unit_data->operator == '*')
                    $product_sale->qty = $product_sale->qty * $lims_sale_unit_data->operation_value;
                else
                    $product_sale->qty = $product_sale->qty / $lims_sale_unit_data->operation_value;
                if ($product_sale->variant_id) {
                    $lims_product_variant_data = ProductVariant::select('id', 'qty')->FindExactProduct($lims_product_data->id, $product_sale->variant_id)->first();
                    $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($lims_product_data->id, $product_sale->variant_id, $lims_sale_data->warehouse_id)->first();
                    $lims_product_variant_data->qty += $product_sale->qty;
                    $lims_product_variant_data->save();
                } elseif ($product_sale->product_batch_id) {
                    $lims_product_batch_data = ProductBatch::find($product_sale->product_batch_id);
                    $lims_product_warehouse_data = Product_Warehouse::where([
                        ['product_batch_id', $product_sale->product_batch_id],
                        ['warehouse_id', $lims_sale_data->warehouse_id]
                    ])->first();

                    $lims_product_batch_data->qty -= $product_sale->qty;
                    $lims_product_batch_data->save();
                } else {
                    $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($lims_product_data->id, $lims_sale_data->warehouse_id)->first();
                }

                $lims_product_data->qty += $product_sale->qty;
                $lims_product_warehouse_data->qty += $product_sale->qty;
                $lims_product_data->save();
                $lims_product_warehouse_data->save();
            }
            if ($product_sale->imei_number) {
                if ($lims_product_warehouse_data->imei_number)
                    $lims_product_warehouse_data->imei_number .= ',' . $product_sale->imei_number;
                else
                    $lims_product_warehouse_data->imei_number = $product_sale->imei_number;
                $lims_product_warehouse_data->save();
            }
            $product_sale->delete();
        }

        $lims_payment_data = Payment::where('sale_id', $id)->get();
        foreach ($lims_payment_data as $payment) {
            if ($payment->paying_method == 'Gift Card') {
                $lims_payment_with_gift_card_data = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                $lims_gift_card_data = GiftCard::find($lims_payment_with_gift_card_data->gift_card_id);
                $lims_gift_card_data->expense -= $payment->amount;
                $lims_gift_card_data->save();
                $lims_payment_with_gift_card_data->delete();
            } elseif ($payment->paying_method == 'Cheque') {
                $lims_payment_cheque_data = PaymentWithCheque::where('payment_id', $payment->id)->first();
                if ($lims_payment_cheque_data)
                    $lims_payment_cheque_data->delete();
            } elseif ($payment->paying_method == 'Credit Card') {
                $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('payment_id', $payment->id)->first();
                if ($lims_payment_with_credit_card_data)
                    $lims_payment_with_credit_card_data->delete();
            } elseif ($payment->paying_method == 'Paypal') {
                $lims_payment_paypal_data = PaymentWithPaypal::where('payment_id', $payment->id)->first();
                if ($lims_payment_paypal_data)
                    $lims_payment_paypal_data->delete();
            } elseif ($payment->paying_method == 'Deposit') {
                $lims_customer_data = Customer::find($lims_sale_data->customer_id);
                $lims_customer_data->expense -= $payment->amount;
                $lims_customer_data->save();
            }
            $payment->delete();
        }
        if ($lims_delivery_data)
            $lims_delivery_data->delete();
        if ($lims_sale_data->coupon_id) {
            $lims_coupon_data = Coupon::find($lims_sale_data->coupon_id);
            $lims_coupon_data->used -= 1;
            $lims_coupon_data->save();
        }
        $lims_sale_data->delete();
        $this->fileDelete('documents/sale/', $lims_sale_data->document);

        return Redirect::to($url)->with('not_permitted', $message);
    }
}

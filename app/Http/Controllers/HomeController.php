<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\MoneyTransfer;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\Product;
use App\Enums\ProductType;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use App\Models\Quotation;
use App\Models\ReturnPurchase;
use App\Models\Returns;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Printing;
use Rawilk\Printing\Contracts\Printer;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    use \App\Traits\AutoUpdateTrait;

    public function home()
    {
        // return view('backend.home');
        return redirect('dashboard');
    }

    public function index()
    {
        return redirect('dashboard');
    }

    public function documentation()
    {
        $general_setting = Cache::remember('general_setting', 60 * 60 * 24 * 365, function () {
            return DB::table('general_settings')->latest()->first();
        });
        return view('backend.documentation', compact('general_setting'));
    }

    public function addonList()
    {
        return view('backend.addonlist');
    }

    public function dashboard()
    {
        if (Auth::user()->role_id == 5) {
            $customer = Customer::select('id', 'points')->where('user_id', Auth::id())->first();
            if ($customer) {
                $lims_sale_data = Sale::with('warehouse')
                    ->where('customer_id', $customer->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $lims_payment_data = DB::table('payments')
                    ->join('sales', 'payments.sale_id', '=', 'sales.id')
                    ->where('customer_id', $customer->id)
                    ->select('payments.*', 'sales.reference_no as sale_reference')
                    ->orderBy('payments.created_at', 'desc')
                    ->get();

                $lims_quotation_data = Quotation::with('biller', 'customer', 'supplier', 'user')
                    ->where('customer_id', $customer->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $lims_return_data = Returns::with('warehouse', 'customer', 'biller')
                    ->where('customer_id', $customer->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $lims_reward_point_setting_data = RewardPointSetting::select('per_point_amount')->latest()->first();
                return view('backend.customer_index', compact('customer', 'lims_sale_data', 'lims_payment_data', 'lims_quotation_data', 'lims_return_data', 'lims_reward_point_setting_data'));
            }
        }

        $start_date = date("Y-m-01");
        $end_date = date("Y-m-t");
        $start_dt = $start_date . ' 00:00:00';
        $end_dt = $end_date . ' 23:59:59';
        $yearly_sale_amount = [];
        $is_staff_own = (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own');
        $auth_user_id = Auth::id();

        $ps_query = Product_Sale::join('sales', 'sales.id', '=', 'product_sales.sale_id')
            ->select(
                'product_sales.product_id',
                'product_sales.product_batch_id',
                'product_sales.variant_id',
                'product_sales.sale_unit_id',
                DB::raw('SUM(product_sales.qty) as sold_qty'),
                DB::raw('SUM(COALESCE(product_sales.return_qty, 0)) as return_qty'),
                DB::raw('SUM(product_sales.total) as sold_amount')
            )
            ->where('sales.created_at', '>=', $start_dt)
            ->where('sales.created_at', '<=', $end_dt);

        if ($is_staff_own) {
            $ps_query->where('sales.user_id', $auth_user_id);
        }
        $product_sale_data = $ps_query->groupBy('product_sales.product_id', 'product_sales.product_batch_id', 'product_sales.variant_id', 'product_sales.sale_unit_id')->get();
        $product_cost = $this->calculateAverageCOGS($product_sale_data);

        $sale_sums = Sale::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $sale_sums->where('user_id', $auth_user_id);
        $sale_result = $sale_sums->selectRaw('
            SUM(grand_total - shipping_cost) as revenue,
            SUM(grand_total - paid_amount) as sale_due,
            SUM(paid_amount) as sale_paid
        ')->first();

        $revenue = (float)($sale_result->revenue ?? 0);
        $sale_due = (float)($sale_result->sale_due ?? 0);
        $sale_paid = (float)($sale_result->sale_paid ?? 0);

        $purchase_sums = Purchase::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $purchase_sums->where('user_id', $auth_user_id);
        $purchase_result = $purchase_sums->selectRaw('
            SUM(grand_total) as purchase,
            SUM(paid_amount) as purchase_paid,
            SUM(grand_total - paid_amount) as purchase_due
        ')->first();

        $purchase = (float)($purchase_result->purchase ?? 0);
        $purchase_paid = (float)($purchase_result->purchase_paid ?? 0);
        $purchase_due = (float)($purchase_result->purchase_due ?? 0);

        $due_pmt_query = Payment::join('sales', 'payments.sale_id', '=', 'sales.id')
            ->where('payments.due_payment', 1)
            ->whereRaw('payments.created_at > sales.created_at')
            ->where('payments.created_at', '>=', $start_dt)
            ->where('payments.created_at', '<=', $end_dt);
        if ($is_staff_own) $due_pmt_query->where('payments.user_id', $auth_user_id);
        $due_payment_received = (float)$due_pmt_query->sum('payments.amount');

        $return_query = Returns::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $return_query->where('user_id', $auth_user_id);
        $return = (float)$return_query->sum('grand_total');

        $preturn_query = ReturnPurchase::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $preturn_query->where('user_id', $auth_user_id);
        $purchase_return = (float)$preturn_query->sum('grand_total');

        $revenue = $revenue - $return;
        $profit = $revenue + $purchase_return - $product_cost;

        $exp_query = Expense::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $exp_query->where('user_id', $auth_user_id);
        $expense = (float)$exp_query->sum('amount');

        $pay_query = Payroll::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $pay_query->where('user_id', $auth_user_id);
        $salary = (float)$pay_query->sum('amount');

        $customers = Customer::where('is_active', 1)->count();
        $suppliers = Supplier::where('is_active', 1)->count();
        //cash flow of last 6 months
        $start_ts = strtotime(date('Y-m-01', strtotime('-6 month', strtotime(date('Y-m-d')))));
        $end_ts = strtotime(date('Y-m-' . date('t', mktime(0, 0, 0, date("m"), 1, date("Y")))));
        $cf_start_date = date("Y-m-d", $start_ts);
        $cf_end_date = date("Y-m-d", $end_ts);
        $cf_start_dt = $cf_start_date . ' 00:00:00';
        $cf_end_dt = $cf_end_date . ' 23:59:59';

        $is_staff_own = (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own');
        $auth_user_id = Auth::id();

        $cf_payments_query = DB::table('payments')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, 
                         SUM(CASE WHEN sale_id IS NOT NULL THEN amount ELSE 0 END) as recv_total,
                         SUM(CASE WHEN purchase_id IS NOT NULL THEN amount ELSE 0 END) as sent_total")
            ->where('created_at', '>=', $cf_start_dt)
            ->where('created_at', '<=', $cf_end_dt);
        if ($is_staff_own) $cf_payments_query->where('user_id', $auth_user_id);
        $cf_payments_data = $cf_payments_query->groupBy('ym')->get()->keyBy('ym');

        $cf_returns = Returns::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(grand_total) as total")
            ->where('created_at', '>=', $cf_start_dt)->where('created_at', '<=', $cf_end_dt);
        if ($is_staff_own) $cf_returns->where('user_id', $auth_user_id);
        $cf_returns_data = $cf_returns->groupBy('ym')->pluck('total', 'ym');

        $cf_purchase_returns = ReturnPurchase::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(grand_total) as total")
            ->where('created_at', '>=', $cf_start_dt)->where('created_at', '<=', $cf_end_dt);
        if ($is_staff_own) $cf_purchase_returns->where('user_id', $auth_user_id);
        $cf_purchase_returns_data = $cf_purchase_returns->groupBy('ym')->pluck('total', 'ym');

        $cf_expenses = Expense::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(amount) as total")
            ->where('created_at', '>=', $cf_start_dt)->where('created_at', '<=', $cf_end_dt);
        if ($is_staff_own) $cf_expenses->where('user_id', $auth_user_id);
        $cf_expenses_data = $cf_expenses->groupBy('ym')->pluck('total', 'ym');

        $cf_payrolls = Payroll::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(amount) as total")
            ->where('created_at', '>=', $cf_start_dt)->where('created_at', '<=', $cf_end_dt);
        if ($is_staff_own) $cf_payrolls->where('user_id', $auth_user_id);
        $cf_payrolls_data = $cf_payrolls->groupBy('ym')->pluck('total', 'ym');

        $payment_recieved = [];
        $payment_sent = [];
        $month = [];

        $curr = $start_ts;
        while ($curr < $end_ts) {
            $ym = date("Y-m", $curr);
            $pmt_row = $cf_payments_data->get($ym);
            $recieved_amount = (float)($pmt_row->recv_total ?? 0);
            $purchase_return_amount = (float)($cf_purchase_returns_data[$ym] ?? 0);
            $sent_amount = (float)($pmt_row->sent_total ?? 0)
                + (float)($cf_returns_data[$ym] ?? 0)
                + (float)($cf_expenses_data[$ym] ?? 0)
                + (float)($cf_payrolls_data[$ym] ?? 0);

            $payment_recieved[] = number_format((float) ($recieved_amount + $purchase_return_amount), config('decimal'), '.', '');
            $payment_sent[] = number_format((float) $sent_amount, config('decimal'), '.', '');
            $month[] = date("F", $curr);
            $curr = strtotime("+1 month", $curr);
        }

        // yearly report
        $y_start_date = date("Y") . '-01-01';
        $y_end_date = date("Y") . '-12-31';

        $y_sales = Sale::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(grand_total) as total")
            ->where('created_at', '>=', $y_start_date . ' 00:00:00')->where('created_at', '<=', $y_end_date . ' 23:59:59');
        if ($is_staff_own) $y_sales->where('user_id', $auth_user_id);
        $y_sales_data = $y_sales->groupBy('ym')->pluck('total', 'ym');

        $y_purchases = Purchase::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, sum(grand_total) as total")
            ->where('created_at', '>=', $y_start_date . ' 00:00:00')->where('created_at', '<=', $y_end_date . ' 23:59:59');
        if ($is_staff_own) $y_purchases->where('user_id', $auth_user_id);
        $y_purchases_data = $y_purchases->groupBy('ym')->pluck('total', 'ym');

        $yearly_sale_amount = [];
        $yearly_purchase_amount = [];
        $sale_chart_labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $curr = strtotime($y_start_date);
        $y_end_ts = strtotime($y_end_date);
        while ($curr < $y_end_ts) {
            $ym = date("Y-m", $curr);
            $yearly_sale_amount[] = (float) number_format((float) ($y_sales_data[$ym] ?? 0), config('decimal'), '.', '');
            $yearly_purchase_amount[] = (float) number_format((float) ($y_purchases_data[$ym] ?? 0), config('decimal'), '.', '');
            $curr = strtotime("+1 month", $curr);
        }

        $initial_balance = Account::where('is_active', true)->sum('initial_balance');
        $pmt_totals = Payment::selectRaw('
            SUM(CASE WHEN sale_id IS NOT NULL THEN amount ELSE 0 END) as total_cashin,
            SUM(CASE WHEN purchase_id IS NOT NULL THEN amount ELSE 0 END) as total_cashout
        ')->first();
        $dep_sum = (float)(Deposit::sum('amount') ?? 0);
        $ret_pur_sum = (float)(ReturnPurchase::sum('grand_total') ?? 0);
        $exp_sum = (float)(Expense::sum('amount') ?? 0);
        $ret_sale_sum = (float)(Returns::sum('grand_total') ?? 0);
        $pay_sum = (float)(Payroll::sum('amount') ?? 0);

        $cashin = (float)($pmt_totals->total_cashin ?? 0) + $dep_sum + $ret_pur_sum;
        $cashout = (float)($pmt_totals->total_cashout ?? 0) + $exp_sum + $ret_sale_sum + $pay_sum;
        $total_current_balance = $initial_balance + $cashin - $cashout;
        $cash = collect(['in' => $cashin, 'out' => $cashout, 'initial_balance' => $initial_balance, 'balance' => $total_current_balance]);

        $stock_calc = Product::selectRaw('sum(COALESCE(qty, 0) * COALESCE(cost, 0)) as total_stock_value, sum(COALESCE(qty, 0) * COALESCE(price, 0)) as total_stock_price')
            ->where('is_active', true)->first();

        $sale_tot_due = Sale::selectRaw('sum(grand_total - paid_amount) as total_due_from_sale')->first()->total_due_from_sale ?? 0;
        $pur_tot_due = Purchase::selectRaw('sum(grand_total - paid_amount) as total_due_from_purchase')->first()->total_due_from_purchase ?? 0;

        $assets = collect([
            'total_stock_value' => $stock_calc->total_stock_value ?? 0,
            'total_stock_price' => $stock_calc->total_stock_price ?? 0,
            'total_due' => $sale_tot_due,
            'total_current_balance' => $total_current_balance
        ]);

        $liability = collect([
            'total_due' => $pur_tot_due,
            'customer_advance' => $dep_sum,
        ]);
        return view('backend.index', compact('purchase_paid', 'purchase_due', 'due_payment_received', 'sale_due', 'sale_paid', 'salary', 'customers', 'suppliers', 'cash', 'liability', 'assets', 'revenue', 'purchase', 'expense', 'return', 'purchase_return', 'profit', 'payment_recieved', 'payment_sent', 'month', 'yearly_sale_amount', 'yearly_purchase_amount', 'sale_chart_labels'));
    }

    public function yearlyBestSellingPrice()
    {
        config()->set('database.connections.mysql.strict', false);
        $yearly_best_selling_price = Product_Sale::join('products', 'products.id', '=', 'product_sales.product_id')
            ->select(DB::raw('products.name as product_name, products.code as product_code, products.image as product_images, sum(total) as total_price'))
            ->whereDate('product_sales.created_at', '>=', date("Y") . '-01-01')
            ->whereDate('product_sales.created_at', '<=', date("Y") . '-12-31')
            ->groupBy('products.code')
            ->orderBy('total_price', 'desc')
            ->take(20)
            ->get();

        return response()->json($yearly_best_selling_price);
    }

    public function yearlyBestSellingQty()
    {
        config()->set('database.connections.mysql.strict', false);
        $yearly_best_selling_qty = Product_Sale::join('products', 'products.id', '=', 'product_sales.product_id')
            ->select(DB::raw('products.name as product_name, products.code as product_code, products.image as product_images, sum(product_sales.qty) as sold_qty'))
            ->whereDate('product_sales.created_at', '>=', date("Y") . '-01-01')
            ->whereDate('product_sales.created_at', '<=', date("Y") . '-12-31')
            ->groupBy('products.code')
            ->orderBy('sold_qty', 'desc')
            ->take(20)
            ->get();

        return response()->json($yearly_best_selling_qty);
    }

    public function dashboardBestSeller(Request $request)
    {
        $start_date = $request->input('start_date', date("Y-m-01"));
        $end_date = $request->input('end_date', date("Y-m-d"));

        config()->set('database.connections.mysql.strict', false);

        $is_staff_own = (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own');
        $user_id = Auth::id();

        $aggQuery = Product_Sale::join('sales', 'sales.id', '=', 'product_sales.sale_id')
            ->select(
                'product_sales.product_id',
                DB::raw('SUM(product_sales.qty) as sold_qty'),
                DB::raw('SUM(product_sales.total) as sold_amount')
            )
            ->where('sales.created_at', '>=', $start_date . ' 00:00:00')
            ->where('sales.created_at', '<=', $end_date . ' 23:59:59');

        if ($is_staff_own) {
            $aggQuery->where('sales.user_id', $user_id);
        }

        $aggQuery->groupBy('product_sales.product_id')
            ->orderBy('sold_qty', 'desc')
            ->take(5);

        $best_sellers = DB::table(DB::raw("({$aggQuery->toSql()}) as ps_agg"))
            ->mergeBindings($aggQuery->getQuery())
            ->join('products', 'products.id', '=', 'ps_agg.product_id')
            ->select(
                'products.name as product_name',
                'products.code as product_code',
                'products.image as product_images',
                'ps_agg.sold_qty',
                'ps_agg.sold_amount'
            )
            ->orderBy('ps_agg.sold_qty', 'desc')
            ->get();

        return response()->json($best_sellers);
    }

    public function recentSale()
    {
        if (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own') {
            $recent_sale = Sale::join('customers', 'customers.id', '=', 'sales.customer_id')->select('sales.id', 'sales.reference_no', 'sales.sale_status', 'sales.created_at', 'sales.grand_total', 'sales.user_id', 'customers.name')->orderBy('id', 'desc')->where('sales.user_id', Auth::id())->take(5)->get();
            return response()->json($recent_sale);
        } else {
            $recent_sale = Sale::join('customers', 'customers.id', '=', 'sales.customer_id')->select('sales.id', 'sales.reference_no', 'sales.sale_status', 'sales.created_at', 'sales.grand_total', 'customers.name')->orderBy('id', 'desc')->take(5)->get();
            return response()->json($recent_sale);
        }
    }

    public function recentPurchase()
    {
        if (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own') {
            $recent_purchase = Purchase::join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')->select('purchases.id', 'purchases.reference_no', 'purchases.payment_status', 'purchases.created_at', 'purchases.grand_total', 'purchases.user_id', 'suppliers.name')->orderBy('id', 'desc')->where('purchases.user_id', Auth::id())->take(5)->get();
            return response()->json($recent_purchase);
        } else {
            $recent_purchase = Purchase::join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')->select('purchases.id', 'purchases.reference_no', 'purchases.payment_status', 'purchases.created_at', 'purchases.grand_total', 'suppliers.name')->orderBy('id', 'desc')->take(5)->get();
            return response()->json($recent_purchase);
        }
    }

    public function recentQuotation()
    {
        if (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own') {
            $recent_quotation = Quotation::join('customers', 'customers.id', '=', 'quotations.customer_id')->select('quotations.id', 'quotations.reference_no', 'quotations.quotation_status', 'quotations.created_at', 'quotations.grand_total', 'quotations.user_id', 'customers.name')->orderBy('id', 'desc')->where('quotations.user_id', Auth::id())->take(5)->get();
            return response()->json($recent_quotation);
        } else {
            $recent_quotation = Quotation::join('customers', 'customers.id', '=', 'quotations.customer_id')->select('quotations.id', 'quotations.reference_no', 'quotations.quotation_status', 'quotations.created_at', 'quotations.grand_total', 'customers.name')->orderBy('id', 'desc')->take(5)->get();
            return response()->json($recent_quotation);
        }
    }

    public function recentPayment()
    {
        if (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own') {
            $recent_payment = Payment::select('id', 'payment_reference', 'amount', 'paying_method', 'created_at', 'user_id')->orderBy('id', 'desc')->where('user_id', Auth::id())->take(5)->get();
            return response()->json($recent_payment);
        } else {
            $recent_payment = Payment::select('id', 'payment_reference', 'amount', 'paying_method', 'created_at')->orderBy('id', 'desc')->take(5)->get();
            return response()->json($recent_payment);
        }
    }

    public function dashboardFilter($start_date, $end_date)
    {
        // Robust normalization to YYYY-MM-DD
        if (preg_match('/^(\d{1,2})[-|\/](\d{1,2})[-|\/](\d{4})$/', $start_date, $m)) {
            $start_date = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        } else {
            $start_date = date('Y-m-d', strtotime($start_date));
        }

        if (preg_match('/^(\d{1,2})[-|\/](\d{1,2})[-|\/](\d{4})$/', $end_date, $m)) {
            $end_date = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        } else {
            $end_date = date('Y-m-d', strtotime($end_date));
        }

        $start_dt = $start_date . ' 00:00:00';
        $end_dt = $end_date . ' 23:59:59';
        $is_staff_own = (Auth::user()->role_id > 2 && cache()->get('general_setting')->staff_access == 'own');
        $auth_user_id = Auth::id();

        $ps_query = Product_Sale::join('sales', 'sales.id', '=', 'product_sales.sale_id')
            ->select(
                'product_sales.product_id',
                'product_sales.product_batch_id',
                'product_sales.variant_id',
                'product_sales.sale_unit_id',
                DB::raw('SUM(product_sales.qty) as sold_qty'),
                DB::raw('SUM(COALESCE(product_sales.return_qty, 0)) as return_qty'),
                DB::raw('SUM(product_sales.total) as sold_amount')
            )
            ->where('sales.created_at', '>=', $start_dt)
            ->where('sales.created_at', '<=', $end_dt);

        if ($is_staff_own) {
            $ps_query->where('sales.user_id', $auth_user_id);
        }
        $product_sale_data = $ps_query->groupBy('product_sales.product_id', 'product_sales.product_batch_id', 'product_sales.variant_id', 'product_sales.sale_unit_id')->get();
        $product_cost = $this->calculateAverageCOGS($product_sale_data);

        $sale_sums = Sale::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $sale_sums->where('user_id', $auth_user_id);
        $sale_result = $sale_sums->selectRaw('
            SUM(grand_total - shipping_cost) as revenue,
            SUM(grand_total - paid_amount) as sale_due,
            SUM(paid_amount) as sale_paid
        ')->first();

        $revenue = (float)($sale_result->revenue ?? 0);
        $sale_due = (float)($sale_result->sale_due ?? 0);
        $sale_paid = (float)($sale_result->sale_paid ?? 0);

        $purchase_sums = Purchase::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $purchase_sums->where('user_id', $auth_user_id);
        $purchase_result = $purchase_sums->selectRaw('
            SUM(grand_total) as purchase,
            SUM(paid_amount) as purchase_paid,
            SUM(grand_total - paid_amount) as purchase_due
        ')->first();

        $purchase = (float)($purchase_result->purchase ?? 0);
        $purchase_paid = (float)($purchase_result->purchase_paid ?? 0);
        $purchase_due = (float)($purchase_result->purchase_due ?? 0);

        $due_pmt_query = Payment::join('sales', 'payments.sale_id', '=', 'sales.id')
            ->where('payments.due_payment', 1)
            ->whereRaw('payments.created_at > sales.created_at')
            ->where('payments.created_at', '>=', $start_dt)
            ->where('payments.created_at', '<=', $end_dt);
        if ($is_staff_own) $due_pmt_query->where('payments.user_id', $auth_user_id);
        $due_payment_received = (float)$due_pmt_query->sum('payments.amount');

        $return_query = Returns::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $return_query->where('user_id', $auth_user_id);
        $return = (float)$return_query->sum('grand_total');

        $preturn_query = ReturnPurchase::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $preturn_query->where('user_id', $auth_user_id);
        $purchase_return = (float)$preturn_query->sum('grand_total');

        $revenue = $revenue - $return;
        $profit = $revenue + $purchase_return - $product_cost;

        $exp_query = Expense::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $exp_query->where('user_id', $auth_user_id);
        $expense = (float)$exp_query->sum('amount');

        $pay_query = Payroll::where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $pay_query->where('user_id', $auth_user_id);
        $salary = (float)$pay_query->sum('amount');

        $data[0] = $revenue;
        $data[1] = $return;
        $data[2] = $profit;
        $data[3] = $purchase_return;
        $data[4] = $expense;
        $data[5] = $salary;
        $data[6] = $purchase;
        $data[7] = $sale_due;
        $data[8] = $sale_paid;
        $data[9] = $due_payment_received;
        $data[10] = $purchase_due;
        $data[11] = $purchase_paid;

        $aggQuery = Product_Sale::join('sales', 'sales.id', '=', 'product_sales.sale_id')
            ->select(
                'product_sales.product_id',
                DB::raw('SUM(product_sales.qty) as sold_qty'),
                DB::raw('SUM(product_sales.total) as sold_amount')
            )
            ->where('sales.created_at', '>=', $start_dt)
            ->where('sales.created_at', '<=', $end_dt);

        if ($is_staff_own) {
            $aggQuery->where('sales.user_id', $auth_user_id);
        }

        $aggQuery->groupBy('product_sales.product_id')
            ->orderBy('sold_qty', 'desc')
            ->take(5);

        $data[12] = DB::table(DB::raw("({$aggQuery->toSql()}) as ps_agg"))
            ->mergeBindings($aggQuery->getQuery())
            ->join('products', 'products.id', '=', 'ps_agg.product_id')
            ->select(
                'products.name as product_name',
                'products.code as product_code',
                'products.image as product_images',
                'ps_agg.sold_qty',
                'ps_agg.sold_amount'
            )
            ->orderBy('ps_agg.sold_qty', 'desc')
            ->get();


        // Dynamic Charts Data (Sales vs Purchase & Cash Flow)
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $diff_days = round(($end_ts - $start_ts) / 86400);

        if ($diff_days < 1 || $start_date == $end_date) {
            $fmt = '%H:00';
        } elseif ($diff_days <= 31) {
            $fmt = '%Y-%m-%d';
        } else {
            $fmt = '%Y-%m';
        }

        // Sales & Purchase for Bar Chart
        $sales_q = Sale::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(grand_total) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $sales_q->where('user_id', $auth_user_id);
        $sales_data = $sales_q->groupBy('time_slot')->pluck('total', 'time_slot');

        $purchases_q = Purchase::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(grand_total) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $purchases_q->where('user_id', $auth_user_id);
        $purchases_data = $purchases_q->groupBy('time_slot')->pluck('total', 'time_slot');

        // Cash Flow Queries (Payment Received vs Payment Sent)
        $cf_pmts_filter_q = DB::table('payments')->selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, 
            SUM(CASE WHEN sale_id IS NOT NULL THEN amount ELSE 0 END) as recv_total,
            SUM(CASE WHEN purchase_id IS NOT NULL THEN amount ELSE 0 END) as sent_total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $cf_pmts_filter_q->where('user_id', $auth_user_id);
        $cf_pmts_filter = $cf_pmts_filter_q->groupBy('time_slot')->get()->keyBy('time_slot');

        $cf_pret_q = ReturnPurchase::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(grand_total) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $cf_pret_q->where('user_id', $auth_user_id);
        $cf_pret = $cf_pret_q->groupBy('time_slot')->pluck('total', 'time_slot');

        $cf_sret_q = Returns::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(grand_total) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $cf_sret_q->where('user_id', $auth_user_id);
        $cf_sret = $cf_sret_q->groupBy('time_slot')->pluck('total', 'time_slot');

        $cf_exp_q = Expense::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(amount) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $cf_exp_q->where('user_id', $auth_user_id);
        $cf_exp = $cf_exp_q->groupBy('time_slot')->pluck('total', 'time_slot');

        $cf_pay_q = Payroll::selectRaw("DATE_FORMAT(created_at, '{$fmt}') as time_slot, SUM(amount) as total")
            ->where('created_at', '>=', $start_dt)->where('created_at', '<=', $end_dt);
        if ($is_staff_own) $cf_pay_q->where('user_id', $auth_user_id);
        $cf_pay = $cf_pay_q->groupBy('time_slot')->pluck('total', 'time_slot');

        $chart_labels = [];
        $chart_sales = [];
        $chart_purchases = [];
        $cf_received = [];
        $cf_sent = [];

        if ($diff_days < 1 || $start_date == $end_date) {
            for ($h = 0; $h < 24; $h++) {
                $slot = sprintf('%02d:00', $h);
                $chart_labels[] = date('g A', strtotime($slot));
                $chart_sales[] = (float) number_format((float)($sales_data[$slot] ?? 0), config('decimal'), '.', '');
                $chart_purchases[] = (float) number_format((float)($purchases_data[$slot] ?? 0), config('decimal'), '.', '');
                $pmt_r = $cf_pmts_filter->get($slot);
                $rec = (float)(($pmt_r->recv_total ?? 0) + ($cf_pret[$slot] ?? 0));
                $snt = (float)(($pmt_r->sent_total ?? 0) + ($cf_sret[$slot] ?? 0) + ($cf_exp[$slot] ?? 0) + ($cf_pay[$slot] ?? 0));
                $cf_received[] = (float) number_format($rec, config('decimal'), '.', '');
                $cf_sent[] = (float) number_format($snt, config('decimal'), '.', '');
            }
        } elseif ($diff_days <= 31) {
            $current = $start_ts;
            while ($current <= $end_ts) {
                $slot = date('Y-m-d', $current);
                $chart_labels[] = date('d M', $current);
                $chart_sales[] = (float) number_format((float)($sales_data[$slot] ?? 0), config('decimal'), '.', '');
                $chart_purchases[] = (float) number_format((float)($purchases_data[$slot] ?? 0), config('decimal'), '.', '');
                $pmt_r = $cf_pmts_filter->get($slot);
                $rec = (float)(($pmt_r->recv_total ?? 0) + ($cf_pret[$slot] ?? 0));
                $snt = (float)(($pmt_r->sent_total ?? 0) + ($cf_sret[$slot] ?? 0) + ($cf_exp[$slot] ?? 0) + ($cf_pay[$slot] ?? 0));
                $cf_received[] = (float) number_format($rec, config('decimal'), '.', '');
                $cf_sent[] = (float) number_format($snt, config('decimal'), '.', '');
                $current = strtotime('+1 day', $current);
            }
        } else {
            $current = strtotime(date('Y-m-01', $start_ts));
            $end_month_ts = strtotime(date('Y-m-01', $end_ts));
            while ($current <= $end_month_ts) {
                $slot = date('Y-m', $current);
                $chart_labels[] = date('M Y', $current);
                $chart_sales[] = (float) number_format((float)($sales_data[$slot] ?? 0), config('decimal'), '.', '');
                $chart_purchases[] = (float) number_format((float)($purchases_data[$slot] ?? 0), config('decimal'), '.', '');
                $pmt_r = $cf_pmts_filter->get($slot);
                $rec = (float)(($pmt_r->recv_total ?? 0) + ($cf_pret[$slot] ?? 0));
                $snt = (float)(($pmt_r->sent_total ?? 0) + ($cf_sret[$slot] ?? 0) + ($cf_exp[$slot] ?? 0) + ($cf_pay[$slot] ?? 0));
                $cf_received[] = (float) number_format($rec, config('decimal'), '.', '');
                $cf_sent[] = (float) number_format($snt, config('decimal'), '.', '');
                $current = strtotime('+1 month', $current);
            }
        }

        $data[13] = [
            'labels' => $chart_labels,
            'sales' => $chart_sales,
            'purchases' => $chart_purchases
        ];

        $data[14] = [
            'labels' => $chart_labels,
            'received' => $cf_received,
            'sent' => $cf_sent
        ];

        return $data;
    }

    public function calculateAverageCOGS($product_sale_data)
    {
        $product_cost = 0;
        if (empty($product_sale_data) || $product_sale_data->isEmpty()) {
            return 0;
        }

        $units = Unit::select('id', 'operator', 'operation_value')->get()->keyBy('id');
        $product_ids = $product_sale_data->pluck('product_id')->unique()->filter()->values()->toArray();
        $products = Product::whereIn('id', $product_ids)->select('id', 'type', 'product_list', 'variant_list', 'qty_list')->get()->keyBy('id');

        $all_needed_product_ids = $product_ids;
        foreach ($products as $p) {
            if ($p->isType(ProductType::COMBO) && $p->product_list) {
                $sub_ids = array_filter(explode(",", $p->product_list));
                $all_needed_product_ids = array_merge($all_needed_product_ids, $sub_ids);
            }
        }
        $all_needed_product_ids = array_values(array_unique($all_needed_product_ids));

        $all_purchases = ProductPurchase::whereIn('product_id', $all_needed_product_ids)
            ->select('product_id', 'product_batch_id', 'variant_id', 'recieved', 'purchase_unit_id', 'total')
            ->get();

        $purchases_by_product = $all_purchases->groupBy('product_id');

        foreach ($product_sale_data as $key => $product_sale) {
            $product_data = $products->get($product_sale->product_id);
            if ($product_data && $product_data->isType(ProductType::COMBO)) {
                $product_list = explode(",", $product_data->product_list);
                $variant_list = $product_data->variant_list ? explode(",", $product_data->variant_list) : [];
                $qty_list = explode(",", $product_data->qty_list);

                foreach ($product_list as $index => $sub_prod_id) {
                    $has_variant = (count($variant_list) && !empty($variant_list[$index]));
                    $variant_id = $has_variant ? $variant_list[$index] : null;

                    $sub_purchases = $purchases_by_product->get($sub_prod_id, collect());
                    if ($has_variant) {
                        $product_purchase_data = $sub_purchases->where('variant_id', $variant_id);
                    } else {
                        $product_purchase_data = $sub_purchases;
                    }

                    $total_received_qty = 0;
                    $total_purchased_amount = 0;
                    $multiplier = isset($qty_list[$index]) ? (float)$qty_list[$index] : 1;
                    $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) * $multiplier;

                    foreach ($product_purchase_data as $product_purchase) {
                        $purchase_unit_data = $units->get($product_purchase->purchase_unit_id);
                        if ($purchase_unit_data) {
                            if ($purchase_unit_data->operator == '*')
                                $total_received_qty += $product_purchase->recieved * $purchase_unit_data->operation_value;
                            else
                                $total_received_qty += $product_purchase->recieved / $purchase_unit_data->operation_value;
                        } else {
                            $total_received_qty += $product_purchase->recieved;
                        }
                        $total_purchased_amount += $product_purchase->total;
                    }
                    if ($total_received_qty)
                        $averageCost = $total_purchased_amount / $total_received_qty;
                    else
                        $averageCost = 0;
                    $product_cost += $sold_qty * $averageCost;
                }
            } else {
                $prod_purchases = $purchases_by_product->get($product_sale->product_id, collect());
                if ($product_sale->product_batch_id) {
                    $product_purchase_data = $prod_purchases->where('product_batch_id', $product_sale->product_batch_id);
                } elseif ($product_sale->variant_id) {
                    $product_purchase_data = $prod_purchases->where('variant_id', $product_sale->variant_id);
                } else {
                    $product_purchase_data = $prod_purchases;
                }

                $total_received_qty = 0;
                $total_purchased_amount = 0;

                if ($product_sale->sale_unit_id) {
                    $sale_unit_data = $units->get($product_sale->sale_unit_id);
                    if ($sale_unit_data) {
                        if ($sale_unit_data->operator == '*')
                            $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) * $sale_unit_data->operation_value;
                        else
                            $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) / $sale_unit_data->operation_value;
                    } else {
                        $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty);
                    }
                } else {
                    $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty);
                }

                foreach ($product_purchase_data as $product_purchase) {
                    $purchase_unit_data = $units->get($product_purchase->purchase_unit_id);
                    if ($purchase_unit_data) {
                        if ($purchase_unit_data->operator == '*')
                            $total_received_qty += $product_purchase->recieved * $purchase_unit_data->operation_value;
                        else
                            $total_received_qty += $product_purchase->recieved / $purchase_unit_data->operation_value;
                    } else {
                        $total_received_qty += $product_purchase->recieved;
                    }
                    $total_purchased_amount += $product_purchase->total;
                }
                if ($total_received_qty)
                    $averageCost = $total_purchased_amount / $total_received_qty;
                else
                    $averageCost = 0;
                $product_cost += $sold_qty * $averageCost;
            }
        }
        return $product_cost;
    }

    public function myTransaction($year, $month)
    {
        $start = 1;
        $number_of_day = date('t', mktime(0, 0, 0, $month, 1, $year));
        while ($start <= $number_of_day) {
            if ($start < 10)
                $date = $year . '-' . $month . '-0' . $start;
            else
                $date = $year . '-' . $month . '-' . $start;
            $sale_generated[$start] = Sale::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $sale_grand_total[$start] = Sale::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $purchase_generated[$start] = Purchase::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $purchase_grand_total[$start] = Purchase::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $quotation_generated[$start] = Quotation::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $quotation_grand_total[$start] = Quotation::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $start++;
        }
        $start_day = date('w', strtotime($year . '-' . $month . '-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));
        return view('backend.user.my_transaction', compact('start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'sale_generated', 'sale_grand_total', 'purchase_generated', 'purchase_grand_total', 'quotation_generated', 'quotation_grand_total'));
    }

    public function switchTheme($theme)
    {
        setcookie('theme', $theme, time() + (86400 * 365), "/");
    }
}

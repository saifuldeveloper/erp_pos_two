<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Returns;
use App\Models\ReturnPurchase;
use App\Models\Expense;
use App\Models\Product_Sale;
use App\Models\Product;
use App\Models\Unit;
use App\Models\ProductPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class OverviewReportController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);

        // Failsafe: dynamically register overview-report permission if not exists
        $permission = DB::table('permissions')->where('name', 'overview-report')->first();
        if (!$permission) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => 'overview-report',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
            $role2Exists = DB::table('roles')->where('id', 2)->exists();
            if ($role2Exists) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ]);
            }
            // Clear spatie permission cache to recognize the new permission
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        if ($role->id <= 2 || $role->hasPermissionTo('overview-report')) {
            $start_date = $request->input('start_date', date("Y-m") . '-01');
            $end_date = $request->input('end_date', date("Y-m-d"));
            $stock_count_id = $request->input('stock_count_id');

            $stock_count_product_ids = [];
            if ($stock_count_id) {
                $stock_count_product_ids = DB::table('stock_count_items')
                    ->where('stock_count_id', $stock_count_id)
                    ->pluck('product_id')
                    ->toArray();
            }

            // Check staff access
            $is_staff_own = Auth::user()->role_id > 2 && config('staff_access') == 'own';

            // 1. Calculate Average COGS for sold items
            config()->set('database.connections.mysql.strict', false);
            DB::reconnect();
            $product_sales_query = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
                ->select(DB::raw('product_sales.product_id, product_sales.product_batch_id, product_sales.sale_unit_id, sum(product_sales.qty) as sold_qty, sum(product_sales.return_qty) as return_qty, sum(product_sales.total) as sold_amount'))
                ->whereDate('sales.created_at', '>=', $start_date)
                ->whereDate('sales.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $product_sales_query->where('sales.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $product_sales_query->whereIn('product_sales.product_id', $stock_count_product_ids);
            }
            $product_sale_data = $product_sales_query->groupBy('product_sales.product_id', 'product_sales.product_batch_id')->get();
            config()->set('database.connections.mysql.strict', true);
            DB::reconnect();

            $product_cost = $this->calculateAverageCOGS($product_sale_data);

            // 2. Grouped Purchases Query
            $purchases_by_supplier = DB::table('product_purchases')
                ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.id')
                ->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                ->select(
                    DB::raw('COALESCE(suppliers.name, "China") as supplier_name'),
                    DB::raw('SUM(product_purchases.qty) as total_qty'),
                    DB::raw('SUM(product_purchases.total) as total_cost'),
                    DB::raw('SUM(product_purchases.qty * product_purchases.selling_price) as total_selling_price')
                )
                ->whereDate('purchases.created_at', '>=', $start_date)
                ->whereDate('purchases.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $purchases_by_supplier->where('purchases.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $purchases_by_supplier->whereIn('product_purchases.product_id', $stock_count_product_ids);
            }
            $purchases_by_supplier = $purchases_by_supplier->groupBy('supplier_name')->get();

            // Calculate totals for purchases
            $purchase_total_qty = 0;
            $purchase_total_cost = 0;
            $purchase_total_selling_price = 0;
            foreach ($purchases_by_supplier as $p) {
                $purchase_total_qty += $p->total_qty;
                $purchase_total_cost += $p->total_cost;
                $purchase_total_selling_price += $p->total_selling_price;
            }

            // 3. Grouped Sales Query (for the single Total Sale row)
            $sales_data_table = DB::table('product_sales')
                ->join('sales', 'product_sales.sale_id', '=', 'sales.id')
                ->select(
                    DB::raw('SUM(product_sales.qty - product_sales.return_qty) as total_qty'),
                    DB::raw('SUM((product_sales.qty - product_sales.return_qty) * product_sales.net_unit_price) as total_revenue')
                )
                ->whereDate('sales.created_at', '>=', $start_date)
                ->whereDate('sales.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $sales_data_table->where('sales.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $sales_data_table->whereIn('product_sales.product_id', $stock_count_product_ids);
            }
            $sales_data_table = $sales_data_table->first();

            $sales_total_qty = $sales_data_table->total_qty ?? 0;
            $sales_total_cost = $product_cost; // Use the calculated average COGS!
            $sales_total_revenue = $sales_data_table->total_revenue ?? 0;

            // 4. Grouped Purchase Returns Query
            $purchase_returns_by_supplier = DB::table('purchase_product_return')
                ->join('return_purchases', 'purchase_product_return.return_id', '=', 'return_purchases.id')
                ->leftJoin('suppliers', 'return_purchases.supplier_id', '=', 'suppliers.id')
                ->join('products', 'purchase_product_return.product_id', '=', 'products.id')
                ->select(
                    DB::raw('COALESCE(suppliers.name, "China") as supplier_name'),
                    DB::raw('SUM(purchase_product_return.qty) as total_qty'),
                    DB::raw('SUM(purchase_product_return.total) as total_cost'),
                    DB::raw('SUM(purchase_product_return.qty * products.price) as total_selling_price')
                )
                ->whereDate('return_purchases.created_at', '>=', $start_date)
                ->whereDate('return_purchases.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $purchase_returns_by_supplier->where('return_purchases.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $purchase_returns_by_supplier->whereIn('purchase_product_return.product_id', $stock_count_product_ids);
            }
            $purchase_returns_by_supplier = $purchase_returns_by_supplier->groupBy('supplier_name')->get();

            // Calculate totals for purchase returns
            $purchase_return_total_qty = 0;
            $purchase_return_total_cost = 0;
            $purchase_return_total_selling_price = 0;
            foreach ($purchase_returns_by_supplier as $pr) {
                $purchase_return_total_qty += $pr->total_qty;
                $purchase_return_total_cost += $pr->total_cost;
                $purchase_return_total_selling_price += $pr->total_selling_price;
            }

            // 5. Grouped Sale Returns Query (for the single Total Sale Return row)
            $sale_returns_data_table = DB::table('product_returns')
                ->join('returns', 'product_returns.return_id', '=', 'returns.id')
                ->select(
                    DB::raw('SUM(product_returns.qty) as total_qty'),
                    DB::raw('SUM(product_returns.total) as total_revenue')
                )
                ->whereDate('returns.created_at', '>=', $start_date)
                ->whereDate('returns.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $sale_returns_data_table->where('returns.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $sale_returns_data_table->whereIn('product_returns.product_id', $stock_count_product_ids);
            }
            $sale_returns_data_table = $sale_returns_data_table->first();

            $sale_returns_total_qty = $sale_returns_data_table->total_qty ?? 0;
            $sale_returns_total_revenue = $sale_returns_data_table->total_revenue ?? 0;

            // Calculate average COGS for returned sales items
            config()->set('database.connections.mysql.strict', false);
            DB::reconnect();
            $sale_returns_items = \App\Models\ProductReturn::join('returns', 'product_returns.return_id', '=', 'returns.id')
                ->select(DB::raw('product_returns.product_id, product_returns.product_batch_id, product_returns.variant_id, sum(product_returns.qty) as sold_qty, 0 as return_qty'))
                ->whereDate('returns.created_at', '>=', $start_date)
                ->whereDate('returns.created_at', '<=', $end_date);
            if ($is_staff_own) {
                $sale_returns_items->where('returns.user_id', Auth::id());
            }
            if ($stock_count_id) {
                $sale_returns_items->whereIn('product_returns.product_id', $stock_count_product_ids);
            }
            $sale_returns_items_data = $sale_returns_items->groupBy('product_returns.product_id', 'product_returns.product_batch_id')->get();
            config()->set('database.connections.mysql.strict', true);
            DB::reconnect();

            $sale_returns_total_cost = $this->calculateAverageCOGS($sale_returns_items_data);

            // 6. Calculate Waste items
            $waste_items_query = DB::table('waste_items')
                ->join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
                ->join('products', 'waste_items.product_id', '=', 'products.id')
                ->select(
                    DB::raw('SUM(waste_items.qty) as total_qty'),
                    DB::raw('SUM(waste_items.qty * waste_items.unit_price) as total_revenue'),
                    DB::raw('SUM(waste_items.qty * products.cost) as total_cost')
                )
                ->whereDate('wastes.created_at', '>=', $start_date)
                ->whereDate('wastes.created_at', '<=', $end_date);
            if ($stock_count_id) {
                $waste_items_query->whereIn('waste_items.product_id', $stock_count_product_ids);
            }
            $waste_data = $waste_items_query->first();

            $waste_total_qty = $waste_data->total_qty ?? 0;
            $waste_total_revenue = $waste_data->total_revenue ?? 0;
            $waste_total_cost = $waste_data->total_cost ?? 0;

            // 7. Stock Count specific metrics
            $stock_count_current_qty = 0;
            $stock_count_current_revenue = 0;
            $stock_count_current_cost = 0;

            $stock_count_updated_qty = 0;
            $stock_count_updated_revenue = 0;
            $stock_count_updated_cost = 0;

            if ($stock_count_id) {
                $stock_count_data = DB::table('stock_count_items')
                    ->join('products', 'stock_count_items.product_id', '=', 'products.id')
                    ->select(
                        DB::raw('SUM(stock_count_items.current_quantity) as current_qty'),
                        DB::raw('SUM(stock_count_items.current_quantity * products.price) as current_revenue'),
                        DB::raw('SUM(stock_count_items.current_quantity * products.cost) as current_cost'),
                        DB::raw('SUM(stock_count_items.updated_quantity) as updated_qty'),
                        DB::raw('SUM(stock_count_items.updated_quantity * products.price) as updated_revenue'),
                        DB::raw('SUM(stock_count_items.updated_quantity * products.cost) as updated_cost')
                    )
                    ->where('stock_count_items.stock_count_id', $stock_count_id)
                    ->first();

                if ($stock_count_data) {
                    $stock_count_current_qty = $stock_count_data->current_qty ?? 0;
                    $stock_count_current_revenue = $stock_count_data->current_revenue ?? 0;
                    $stock_count_current_cost = $stock_count_data->current_cost ?? 0;

                    $stock_count_updated_qty = $stock_count_data->updated_qty ?? 0;
                    $stock_count_updated_revenue = $stock_count_data->updated_revenue ?? 0;
                    $stock_count_updated_cost = $stock_count_data->updated_cost ?? 0;
                }
            }

            return view('backend.report.overview_report', compact(
                'start_date', 'end_date', 'stock_count_id',
                'purchases_by_supplier', 'purchase_total_qty', 'purchase_total_cost', 'purchase_total_selling_price',
                'sales_total_qty', 'sales_total_cost', 'sales_total_revenue',
                'purchase_returns_by_supplier', 'purchase_return_total_qty', 'purchase_return_total_cost', 'purchase_return_total_selling_price',
                'sale_returns_total_qty', 'sale_returns_total_cost', 'sale_returns_total_revenue',
                'waste_total_qty', 'waste_total_revenue', 'waste_total_cost',
                'stock_count_current_qty', 'stock_count_current_revenue', 'stock_count_current_cost',
                'stock_count_updated_qty', 'stock_count_updated_revenue', 'stock_count_updated_cost'
            ));
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    private function calculateAverageCOGS($product_sale_data)
    {
        $product_cost = 0;
        foreach ($product_sale_data as $key => $product_sale) {
            $product_data = Product::select('type', 'product_list', 'variant_list', 'qty_list')->find($product_sale->product_id);
            if ($product_data && $product_data->type == 'combo') {
                $product_list = explode(",", $product_data->product_list);
                $variant_list = $product_data->variant_list ? explode(",", $product_data->variant_list) : [];
                $qty_list = explode(",", $product_data->qty_list);

                foreach ($product_list as $index => $product_id) {
                    if (count($variant_list) && isset($variant_list[$index]) && $variant_list[$index]) {
                        $product_purchase_data = ProductPurchase::where([
                            ['product_id', $product_id],
                            ['variant_id', $variant_list[$index]]
                        ])
                            ->select('recieved', 'purchase_unit_id', 'total')
                            ->get();
                    } else {
                        $product_purchase_data = ProductPurchase::where('product_id', $product_id)
                            ->select('recieved', 'purchase_unit_id', 'total')
                            ->get();
                    }
                    $total_received_qty = 0;
                    $total_purchased_amount = 0;
                    $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) * $qty_list[$index];
                    $units = Unit::select('id', 'operator', 'operation_value')->get();
                    foreach ($product_purchase_data as $pp) {
                        $purchase_unit_data = $units->where('id', $pp->purchase_unit_id)->first();
                        if ($purchase_unit_data) {
                            if ($purchase_unit_data->operator == '*') {
                                $total_received_qty += $pp->recieved * $purchase_unit_data->operation_value;
                            } else {
                                $total_received_qty += $pp->recieved / $purchase_unit_data->operation_value;
                            }
                        } else {
                            $total_received_qty += $pp->recieved;
                        }
                        $total_purchased_amount += $pp->total;
                    }
                    $averageCost = $total_received_qty ? ($total_purchased_amount / $total_received_qty) : 0;
                    $product_cost += $sold_qty * $averageCost;
                }
            } else {
                if ($product_sale->product_batch_id) {
                    $product_purchase_data = ProductPurchase::where([
                        ['product_id', $product_sale->product_id],
                        ['product_batch_id', $product_sale->product_batch_id]
                    ])
                        ->select('recieved', 'purchase_unit_id', 'total')
                        ->get();
                } elseif (isset($product_sale->variant_id) && $product_sale->variant_id) {
                    $product_purchase_data = ProductPurchase::where([
                        ['product_id', $product_sale->product_id],
                        ['variant_id', $product_sale->variant_id]
                    ])
                        ->select('recieved', 'purchase_unit_id', 'total')
                        ->get();
                } else {
                    $product_purchase_data = ProductPurchase::where('product_id', $product_sale->product_id)
                        ->select('recieved', 'purchase_unit_id', 'total')
                        ->get();
                }
                $total_received_qty = 0;
                $total_purchased_amount = 0;
                $units = Unit::select('id', 'operator', 'operation_value')->get();
                if ($product_sale->sale_unit_id) {
                    $sale_unit_data = $units->where('id', $product_sale->sale_unit_id)->first();
                    if ($sale_unit_data) {
                        if ($sale_unit_data->operator == '*') {
                            $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) * $sale_unit_data->operation_value;
                        } else {
                            $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) / $sale_unit_data->operation_value;
                        }
                    } else {
                        $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty);
                    }
                } else {
                    $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty);
                }
                foreach ($product_purchase_data as $pp) {
                    $purchase_unit_data = $units->where('id', $pp->purchase_unit_id)->first();
                    if ($purchase_unit_data) {
                        if ($purchase_unit_data->operator == '*') {
                            $total_received_qty += $pp->recieved * $purchase_unit_data->operation_value;
                        } else {
                            $total_received_qty += $pp->recieved / $purchase_unit_data->operation_value;
                        }
                    } else {
                        $total_received_qty += $pp->recieved;
                    }
                    $total_purchased_amount += $pp->total;
                }
                $averageCost = $total_received_qty ? ($total_purchased_amount / $total_received_qty) : 0;
                $product_cost += $sold_qty * $averageCost;
            }
        }
        return $product_cost;
    }
}

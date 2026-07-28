<?php

namespace App\Http\Controllers;

use App\Models\Product_Sale;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if ($role->hasPermissionTo('overview-report')) {
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

            // 1. Calculate Average COGS for sold items, brand wise
            config()->set('database.connections.mysql.strict', false);
            DB::reconnect();
            $product_sales_query = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
                ->join('products', 'product_sales.product_id', '=', 'products.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->select(DB::raw('product_sales.product_id, product_sales.product_batch_id, product_sales.sale_unit_id, sum(product_sales.qty) as sold_qty, sum(product_sales.return_qty) as return_qty, sum(product_sales.total) as sold_amount, COALESCE(brands.title, "No Brand") as brand_name'))
                ->whereDate('sales.created_at', '>=', $start_date)
                ->whereDate('sales.created_at', '<=', $end_date);
            if ($stock_count_id) {
                $product_sales_query->whereIn('product_sales.product_id', $stock_count_product_ids);
            }
            $product_sale_data = $product_sales_query->groupBy('product_sales.product_id', 'product_sales.product_batch_id', 'brand_name')->get();
            config()->set('database.connections.mysql.strict', true);
            DB::reconnect();

            // Fetch sale returns items data early so we can do bulk preloading
            config()->set('database.connections.mysql.strict', false);
            DB::reconnect();
            $sale_returns_items = ProductReturn::join('returns', 'product_returns.return_id', '=', 'returns.id')
                ->join('products', 'product_returns.product_id', '=', 'products.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->select(DB::raw('product_returns.product_id, product_returns.product_batch_id, product_returns.variant_id, sum(product_returns.qty) as sold_qty, 0 as return_qty, COALESCE(brands.title, "No Brand") as brand_name'))
                ->whereDate('returns.created_at', '>=', $start_date)
                ->whereDate('returns.created_at', '<=', $end_date);
            if ($stock_count_id) {
                $sale_returns_items->whereIn('product_returns.product_id', $stock_count_product_ids);
            }
            $sale_returns_items_data = $sale_returns_items->groupBy('product_returns.product_id', 'product_returns.product_batch_id', 'brand_name')->get();
            config()->set('database.connections.mysql.strict', true);
            DB::reconnect();

            // Preload products, units, and calculate average costs in bulk
            $products = $this->loadProductsAndCombos($product_sale_data, $sale_returns_items_data);
            $units = Unit::all()->keyBy('id');
            $avg_costs = $this->buildAverageCostMaps($products->keys()->toArray());

            // Calculate sales COGS grouped by brand
            $sales_cogs_by_brand = $this->calculateCogsByBrand($product_sale_data, $products, $units, $avg_costs);

            // Fetch purchases data
            $purchases_data = $this->getGroupedPurchases($start_date, $end_date, $stock_count_id, $stock_count_product_ids);
            $purchases_by_brand = $purchases_data['purchases_by_brand'];
            $purchase_total_qty = $purchases_data['purchase_total_qty'];
            $purchase_total_cost = $purchases_data['purchase_total_cost'];
            $purchase_total_selling_price = $purchases_data['purchase_total_selling_price'];

            // Fetch sales data
            $sales_data = $this->getGroupedSales($start_date, $end_date, $stock_count_id, $stock_count_product_ids, $sales_cogs_by_brand);
            $sales_by_brand = $sales_data['sales_by_brand'];
            $sales_total_qty = $sales_data['sales_total_qty'];
            $sales_total_cost = $sales_data['sales_total_cost'];
            $sales_total_revenue = $sales_data['sales_total_revenue'];

            // Fetch purchase returns data
            $purchase_returns_data = $this->getGroupedPurchaseReturns($start_date, $end_date, $stock_count_id, $stock_count_product_ids);
            $purchase_returns_by_brand = $purchase_returns_data['purchase_returns_by_brand'];
            $purchase_return_total_qty = $purchase_returns_data['purchase_return_total_qty'];
            $purchase_return_total_cost = $purchase_returns_data['purchase_return_total_cost'];
            $purchase_return_total_selling_price = $purchase_returns_data['purchase_return_total_selling_price'];

            // Calculate average COGS for returned sales items using preloaded data
            $sale_returns_cogs_by_brand = $this->calculateCogsByBrand($sale_returns_items_data, $products, $units, $avg_costs);

            // Fetch sale returns data
            $sale_returns_data = $this->getGroupedSaleReturns($start_date, $end_date, $stock_count_id, $stock_count_product_ids, $sale_returns_cogs_by_brand);
            $sale_returns_by_brand = $sale_returns_data['sale_returns_by_brand'];
            $sale_returns_total_qty = $sale_returns_data['sale_returns_total_qty'];
            $sale_returns_total_cost = $sale_returns_data['sale_returns_total_cost'];
            $sale_returns_total_revenue = $sale_returns_data['sale_returns_total_revenue'];

            // Fetch waste data
            $waste_totals = $this->getWasteTotals($start_date, $end_date, $stock_count_id, $stock_count_product_ids);
            $waste_total_qty = $waste_totals['waste_total_qty'];
            $waste_total_revenue = $waste_totals['waste_total_revenue'];
            $waste_total_cost = $waste_totals['waste_total_cost'];

            // Fetch stock count specific metrics
            $stock_count_metrics = $this->getStockCountMetrics($stock_count_id);
            $stock_count_current_qty = $stock_count_metrics['stock_count_current_qty'];
            $stock_count_current_revenue = $stock_count_metrics['stock_count_current_revenue'];
            $stock_count_current_cost = $stock_count_metrics['stock_count_current_cost'];
            $stock_count_updated_qty = $stock_count_metrics['stock_count_updated_qty'];
            $stock_count_updated_revenue = $stock_count_metrics['stock_count_updated_revenue'];
            $stock_count_updated_cost = $stock_count_metrics['stock_count_updated_cost'];

            // Fetch adjustments data
            $adjustments_data = $this->getGroupedAdjustments($start_date, $end_date, $stock_count_id, $stock_count_product_ids);
            $adjustments_increment_by_brand = $adjustments_data['adjustments_increment_by_brand'];
            $adj_inc_total_qty = $adjustments_data['adj_inc_total_qty'];
            $adj_inc_total_cost = $adjustments_data['adj_inc_total_cost'];
            $adj_inc_total_selling_price = $adjustments_data['adj_inc_total_selling_price'];

            $adjustments_decrement_by_brand = $adjustments_data['adjustments_decrement_by_brand'];
            $adj_dec_total_qty = $adjustments_data['adj_dec_total_qty'];
            $adj_dec_total_cost = $adjustments_data['adj_dec_total_cost'];
            $adj_dec_total_selling_price = $adjustments_data['adj_dec_total_selling_price'];

            $detailed_adjustments = $this->getDetailedAdjustments($start_date, $end_date, $stock_count_id, $stock_count_product_ids);

            return view('backend.report.overview_report', compact(
                'start_date', 'end_date', 'stock_count_id',
                'purchases_by_brand', 'purchase_total_qty', 'purchase_total_cost', 'purchase_total_selling_price',
                'sales_by_brand', 'sales_total_qty', 'sales_total_cost', 'sales_total_revenue',
                'purchase_returns_by_brand', 'purchase_return_total_qty', 'purchase_return_total_cost', 'purchase_return_total_selling_price',
                'sale_returns_by_brand', 'sale_returns_total_qty', 'sale_returns_total_cost', 'sale_returns_total_revenue',
                'waste_total_qty', 'waste_total_revenue', 'waste_total_cost',
                'stock_count_current_qty', 'stock_count_current_revenue', 'stock_count_current_cost',
                'stock_count_updated_qty', 'stock_count_updated_revenue', 'stock_count_updated_cost',
                'adjustments_increment_by_brand', 'adj_inc_total_qty', 'adj_inc_total_cost', 'adj_inc_total_selling_price',
                'adjustments_decrement_by_brand', 'adj_dec_total_qty', 'adj_dec_total_cost', 'adj_dec_total_selling_price',
                'detailed_adjustments'
            ));
        } else {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }


    /**
     * Helper to preload products and combo sub-products in bulk
     */
    private function loadProductsAndCombos($product_sale_data, $sale_returns_items_data)
    {
        $product_ids = [];
        foreach ($product_sale_data as $ps) {
            $product_ids[] = (int)$ps->product_id;
        }
        foreach ($sale_returns_items_data as $sr) {
            $product_ids[] = (int)$sr->product_id;
        }
        $product_ids = array_unique(array_filter($product_ids));

        $products = Product::whereIn('id', $product_ids)->get()->keyBy('id');
        $sub_product_ids = [];
        foreach ($products as $product) {
            if ($product->type == 'combo') {
                $combo_pids = explode(",", $product->product_list);
                foreach ($combo_pids as $pid) {
                    $sub_product_ids[] = (int)$pid;
                }
            }
        }
        if (!empty($sub_product_ids)) {
            $sub_product_ids = array_unique(array_filter($sub_product_ids));
            $extra_products = Product::whereIn('id', $sub_product_ids)->get()->keyBy('id');
            $products = $products->union($extra_products);
        }

        return $products;
    }

    /**
     * Helper to load purchases and compute average costs in memory to avoid N+1 query problem
     */
    private function buildAverageCostMaps($all_product_ids)
    {
        $purchases = DB::table('product_purchases')
            ->leftJoin('units', 'product_purchases.purchase_unit_id', '=', 'units.id')
            ->select(
                'product_purchases.product_id',
                'product_purchases.product_batch_id',
                'product_purchases.variant_id',
                'product_purchases.recieved',
                'product_purchases.total',
                'units.operator',
                'units.operation_value'
            )
            ->whereIn('product_purchases.product_id', $all_product_ids)
            ->get();

        $batch_cost_map = [];
        $variant_cost_map = [];
        $product_cost_map = [];

        foreach ($purchases as $p) {
            $qty = (float)$p->recieved;
            if ($p->operator == '*') {
                $qty *= (float)$p->operation_value;
            } elseif ($p->operator == '/') {
                $qty /= (float)$p->operation_value;
            }

            $total = (float)$p->total;

            // Product-wide
            if (!isset($product_cost_map[$p->product_id])) {
                $product_cost_map[$p->product_id] = ['cost' => 0.0, 'qty' => 0.0];
            }
            $product_cost_map[$p->product_id]['cost'] += $total;
            $product_cost_map[$p->product_id]['qty'] += $qty;

            // Batch-specific
            if ($p->product_batch_id) {
                $bKey = "{$p->product_id}_{$p->product_batch_id}";
                if (!isset($batch_cost_map[$bKey])) {
                    $batch_cost_map[$bKey] = ['cost' => 0.0, 'qty' => 0.0];
                }
                $batch_cost_map[$bKey]['cost'] += $total;
                $batch_cost_map[$bKey]['qty'] += $qty;
            }

            // Variant-specific
            if ($p->variant_id) {
                $vKey = "{$p->product_id}_{$p->variant_id}";
                if (!isset($variant_cost_map[$vKey])) {
                    $variant_cost_map[$vKey] = ['cost' => 0.0, 'qty' => 0.0];
                }
                $variant_cost_map[$vKey]['cost'] += $total;
                $variant_cost_map[$vKey]['qty'] += $qty;
            }
        }

        $batch_avg_cost = [];
        foreach ($batch_cost_map as $key => $val) {
            $batch_avg_cost[$key] = $val['qty'] > 0 ? ($val['cost'] / $val['qty']) : 0.0;
        }

        $variant_avg_cost = [];
        foreach ($variant_cost_map as $key => $val) {
            $variant_avg_cost[$key] = $val['qty'] > 0 ? ($val['cost'] / $val['qty']) : 0.0;
        }

        $product_avg_cost = [];
        foreach ($product_cost_map as $key => $val) {
            $product_avg_cost[$key] = $val['qty'] > 0 ? ($val['cost'] / $val['qty']) : 0.0;
        }

        return [
            'product' => $product_avg_cost,
            'batch'   => $batch_avg_cost,
            'variant' => $variant_avg_cost,
        ];
    }

    /**
     * Helper to compute COGS by brand using preloaded maps
     */
    private function calculateCogsByBrand($items_data, $products, $units, $avg_costs)
    {
        $cogs_by_brand = [];
        foreach ($items_data as $item) {
            $brand = $item->brand_name ?? 'No Brand';
            if (!isset($cogs_by_brand[$brand])) {
                $cogs_by_brand[$brand] = 0;
            }
            $cogs_by_brand[$brand] += $this->calculateSingleRowCOGS(
                $item,
                $products,
                $units,
                $avg_costs['product'],
                $avg_costs['batch'],
                $avg_costs['variant']
            );
        }
        return $cogs_by_brand;
    }

    private function calculateSingleRowCOGS($product_sale, $products, $units, $product_avg_cost, $batch_avg_cost, $variant_avg_cost)
    {
        $product_cost = 0;
        $product_data = $products->get($product_sale->product_id);

        if ($product_data && $product_data->type == 'combo') {
            $product_list = explode(",", $product_data->product_list);
            $variant_list = $product_data->variant_list ? explode(",", $product_data->variant_list) : [];
            $qty_list = explode(",", $product_data->qty_list);

            foreach ($product_list as $index => $sub_product_id) {
                $sub_product_id = (int)$sub_product_id;
                $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty) * $qty_list[$index];

                if (count($variant_list) && isset($variant_list[$index]) && $variant_list[$index]) {
                    $vKey = "{$sub_product_id}_{$variant_list[$index]}";
                    $averageCost = $variant_avg_cost[$vKey] ?? 0.0;
                } else {
                    $averageCost = $product_avg_cost[$sub_product_id] ?? 0.0;
                }

                $product_cost += $sold_qty * $averageCost;
            }
        } else {
            $sold_qty = ($product_sale->sold_qty - $product_sale->return_qty);
            if ($product_sale->sale_unit_id) {
                $sale_unit_data = $units->get($product_sale->sale_unit_id);
                if ($sale_unit_data) {
                    if ($sale_unit_data->operator == '*') {
                        $sold_qty *= $sale_unit_data->operation_value;
                    } elseif ($sale_unit_data->operator == '/') {
                        $sold_qty /= $sale_unit_data->operation_value;
                    }
                }
            }

            if ($product_sale->product_batch_id) {
                $bKey = "{$product_sale->product_id}_{$product_sale->product_batch_id}";
                $averageCost = $batch_avg_cost[$bKey] ?? 0.0;
            } elseif (isset($product_sale->variant_id) && $product_sale->variant_id) {
                $vKey = "{$product_sale->product_id}_{$product_sale->variant_id}";
                $averageCost = $variant_avg_cost[$vKey] ?? 0.0;
            } else {
                $averageCost = $product_avg_cost[$product_sale->product_id] ?? 0.0;
            }

            $product_cost += $sold_qty * $averageCost;
        }
        return $product_cost;
    }

    /**
     * Helper to load grouped purchases
     */
    private function getGroupedPurchases($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
        $purchases_by_brand = DB::table('product_purchases')
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.id')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                DB::raw('SUM(product_purchases.qty) as total_qty'),
                DB::raw('SUM(product_purchases.total) as total_cost'),
                DB::raw('SUM(product_purchases.qty * product_purchases.selling_price) as total_selling_price')
            )
            ->whereDate('purchases.created_at', '>=', $start_date)
            ->whereDate('purchases.created_at', '<=', $end_date);
        if ($stock_count_id) {
            $purchases_by_brand->whereIn('product_purchases.product_id', $stock_count_product_ids);
        }
        $purchases_by_brand = $purchases_by_brand->groupBy('brand_name')->get();

        $purchase_total_qty = 0;
        $purchase_total_cost = 0;
        $purchase_total_selling_price = 0;
        foreach ($purchases_by_brand as $p) {
            $purchase_total_qty += $p->total_qty;
            $purchase_total_cost += $p->total_cost;
            $purchase_total_selling_price += $p->total_selling_price;
        }

        return [
            'purchases_by_brand' => $purchases_by_brand,
            'purchase_total_qty' => $purchase_total_qty,
            'purchase_total_cost' => $purchase_total_cost,
            'purchase_total_selling_price' => $purchase_total_selling_price
        ];
    }

    /**
     * Helper to load grouped sales
     */
    private function getGroupedSales($start_date, $end_date, $stock_count_id, $stock_count_product_ids, $sales_cogs_by_brand)
    {
        $sales_by_brand = DB::table('product_sales')
            ->join('sales', 'product_sales.sale_id', '=', 'sales.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                DB::raw('SUM(product_sales.qty - product_sales.return_qty) as total_qty'),
                DB::raw('SUM((product_sales.qty - product_sales.return_qty) * product_sales.net_unit_price) as total_revenue')
            )
            ->whereDate('sales.created_at', '>=', $start_date)
            ->whereDate('sales.created_at', '<=', $end_date);
        if ($stock_count_id) {
            $sales_by_brand->whereIn('product_sales.product_id', $stock_count_product_ids);
        }
        $sales_by_brand = $sales_by_brand->groupBy('brand_name')->get();

        $sales_total_qty = 0;
        $sales_total_cost = 0;
        $sales_total_revenue = 0;
        foreach ($sales_by_brand as $s) {
            $s->total_cost = $sales_cogs_by_brand[$s->brand_name] ?? 0;
            $sales_total_qty += $s->total_qty;
            $sales_total_cost += $s->total_cost;
            $sales_total_revenue += $s->total_revenue;
        }

        return [
            'sales_by_brand' => $sales_by_brand,
            'sales_total_qty' => $sales_total_qty,
            'sales_total_cost' => $sales_total_cost,
            'sales_total_revenue' => $sales_total_revenue
        ];
    }

    /**
     * Helper to load grouped purchase returns
     */
    private function getGroupedPurchaseReturns($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
        $purchase_returns_by_brand = DB::table('purchase_product_return')
            ->join('return_purchases', 'purchase_product_return.return_id', '=', 'return_purchases.id')
            ->join('products', 'purchase_product_return.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                DB::raw('SUM(purchase_product_return.qty) as total_qty'),
                DB::raw('SUM(purchase_product_return.total) as total_cost'),
                DB::raw('SUM(purchase_product_return.qty * products.price) as total_selling_price')
            )
            ->whereDate('return_purchases.created_at', '>=', $start_date)
            ->whereDate('return_purchases.created_at', '<=', $end_date);
        if ($stock_count_id) {
            $purchase_returns_by_brand->whereIn('purchase_product_return.product_id', $stock_count_product_ids);
        }
        $purchase_returns_by_brand = $purchase_returns_by_brand->groupBy('brand_name')->get();

        $purchase_return_total_qty = 0;
        $purchase_return_total_cost = 0;
        $purchase_return_total_selling_price = 0;
        foreach ($purchase_returns_by_brand as $pr) {
            $purchase_return_total_qty += $pr->total_qty;
            $purchase_return_total_cost += $pr->total_cost;
            $purchase_return_total_selling_price += $pr->total_selling_price;
        }

        return [
            'purchase_returns_by_brand' => $purchase_returns_by_brand,
            'purchase_return_total_qty' => $purchase_return_total_qty,
            'purchase_return_total_cost' => $purchase_return_total_cost,
            'purchase_return_total_selling_price' => $purchase_return_total_selling_price
        ];
    }

    /**
     * Helper to load grouped sale returns
     */
    private function getGroupedSaleReturns($start_date, $end_date, $stock_count_id, $stock_count_product_ids, $sale_returns_cogs_by_brand)
    {
        $sale_returns_by_brand = DB::table('product_returns')
            ->join('returns', 'product_returns.return_id', '=', 'returns.id')
            ->join('products', 'product_returns.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                DB::raw('SUM(product_returns.qty) as total_qty'),
                DB::raw('SUM(product_returns.total) as total_revenue')
            )
            ->whereDate('returns.created_at', '>=', $start_date)
            ->whereDate('returns.created_at', '<=', $end_date);
        if ($stock_count_id) {
            $sale_returns_by_brand->whereIn('product_returns.product_id', $stock_count_product_ids);
        }
        $sale_returns_by_brand = $sale_returns_by_brand->groupBy('brand_name')->get();

        $sale_returns_total_qty = 0;
        $sale_returns_total_cost = 0;
        $sale_returns_total_revenue = 0;
        foreach ($sale_returns_by_brand as $sr) {
            $sr->total_cost = $sale_returns_cogs_by_brand[$sr->brand_name] ?? 0;
            $sale_returns_total_qty += $sr->total_qty;
            $sale_returns_total_cost += $sr->total_cost;
            $sale_returns_total_revenue += $sr->total_revenue;
        }

        return [
            'sale_returns_by_brand' => $sale_returns_by_brand,
            'sale_returns_total_qty' => $sale_returns_total_qty,
            'sale_returns_total_cost' => $sale_returns_total_cost,
            'sale_returns_total_revenue' => $sale_returns_total_revenue
        ];
    }

    /**
     * Helper to load waste totals
     */
    private function getWasteTotals($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
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

        return [
            'waste_total_qty' => $waste_data->total_qty ?? 0,
            'waste_total_revenue' => $waste_data->total_revenue ?? 0,
            'waste_total_cost' => $waste_data->total_cost ?? 0
        ];
    }

    /**
     * Helper to load stock count specific metrics
     */
    private function getStockCountMetrics($stock_count_id)
    {
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

        return [
            'stock_count_current_qty' => $stock_count_current_qty,
            'stock_count_current_revenue' => $stock_count_current_revenue,
            'stock_count_current_cost' => $stock_count_current_cost,
            'stock_count_updated_qty' => $stock_count_updated_qty,
            'stock_count_updated_revenue' => $stock_count_updated_revenue,
            'stock_count_updated_cost' => $stock_count_updated_cost
        ];
    }

    /**
     * Helper to load grouped adjustments
     */
    private function getGroupedAdjustments($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
        $adjustments_increment_by_brand = [];
        $adjustments_decrement_by_brand = [];

        $adj_inc_total_qty = 0;
        $adj_inc_total_cost = 0;
        $adj_inc_total_selling_price = 0;

        $adj_dec_total_qty = 0;
        $adj_dec_total_cost = 0;
        $adj_dec_total_selling_price = 0;

        $grouped = [];

        // 1. Fetch from stock_count_items if stock_count_id is set OR in the date range
        $stock_adjustments_query = DB::table('stock_count_items')
            ->join('stock_counts', 'stock_count_items.stock_count_id', '=', 'stock_counts.id')
            ->join('products', 'stock_count_items.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                'stock_count_items.current_quantity',
                'stock_count_items.updated_quantity',
                'products.cost',
                'products.price'
            )
            ->whereRaw('stock_count_items.updated_quantity != stock_count_items.current_quantity');

        if ($stock_count_id) {
            $stock_adjustments_query->where('stock_count_items.stock_count_id', $stock_count_id);
        } else {
            $stock_adjustments_query->whereDate('stock_counts.updated_at', '>=', $start_date)
                                   ->whereDate('stock_counts.updated_at', '<=', $end_date)
                                   ->where('stock_counts.is_resolved', true);
        }

        $stock_adjustments = $stock_adjustments_query->get();

        foreach ($stock_adjustments as $sa) {
            $brand = $sa->brand_name;
            $diff = $sa->updated_quantity - $sa->current_quantity;
            $action = $diff > 0 ? '+' : '-';
            $qty = abs($diff);
            $cost = $qty * $sa->cost;
            $price = $qty * $sa->price;

            $key = "{$brand}_{$action}";
            if (!isset($grouped[$key])) {
                $grouped[$key] = (object)[
                    'brand_name' => $brand,
                    'action' => $action,
                    'total_qty' => 0,
                    'total_cost' => 0,
                    'total_selling_price' => 0
                ];
            }
            $grouped[$key]->total_qty += $qty;
            $grouped[$key]->total_cost += $cost;
            $grouped[$key]->total_selling_price += $price;
        }

        // 2. Fetch from manual product_adjustments if stock_count_id is NOT set
        if (!$stock_count_id) {
            $manual_adjustments = DB::table('product_adjustments')
                ->join('adjustments', 'product_adjustments.adjustment_id', '=', 'adjustments.id')
                ->join('products', 'product_adjustments.product_id', '=', 'products.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->select(
                    DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                    'product_adjustments.action',
                    DB::raw('SUM(product_adjustments.qty) as total_qty'),
                    DB::raw('SUM(product_adjustments.qty * products.cost) as total_cost'),
                    DB::raw('SUM(product_adjustments.qty * products.price) as total_selling_price')
                )
                ->whereDate('adjustments.created_at', '>=', $start_date)
                ->whereDate('adjustments.created_at', '<=', $end_date)
                ->groupBy('brand_name', 'product_adjustments.action')
                ->get();

            foreach ($manual_adjustments as $ma) {
                $brand = $ma->brand_name;
                $action = $ma->action;
                $qty = $ma->total_qty;
                $cost = $ma->total_cost;
                $price = $ma->total_selling_price;

                $key = "{$brand}_{$action}";
                if (!isset($grouped[$key])) {
                    $grouped[$key] = (object)[
                        'brand_name' => $brand,
                        'action' => $action,
                        'total_qty' => 0,
                        'total_cost' => 0,
                        'total_selling_price' => 0
                    ];
                }
                $grouped[$key]->total_qty += $qty;
                $grouped[$key]->total_cost += $cost;
                $grouped[$key]->total_selling_price += $price;
            }
        }

        // 3. Separate into increment and decrement arrays
        foreach ($grouped as $g) {
            if ($g->action == '+') {
                $adjustments_increment_by_brand[] = $g;
                $adj_inc_total_qty += $g->total_qty;
                $adj_inc_total_cost += $g->total_cost;
                $adj_inc_total_selling_price += $g->total_selling_price;
            } else {
                $adjustments_decrement_by_brand[] = $g;
                $adj_dec_total_qty += $g->total_qty;
                $adj_dec_total_cost += $g->total_cost;
                $adj_dec_total_selling_price += $g->total_selling_price;
            }
        }

        return [
            'adjustments_increment_by_brand' => $adjustments_increment_by_brand,
            'adj_inc_total_qty' => $adj_inc_total_qty,
            'adj_inc_total_cost' => $adj_inc_total_cost,
            'adj_inc_total_selling_price' => $adj_inc_total_selling_price,

            'adjustments_decrement_by_brand' => $adjustments_decrement_by_brand,
            'adj_dec_total_qty' => $adj_dec_total_qty,
            'adj_dec_total_cost' => $adj_dec_total_cost,
            'adj_dec_total_selling_price' => $adj_dec_total_selling_price,
        ];
    }

    /**
     * Helper to load detailed adjustments
     */
    private function getDetailedAdjustments($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
        $detailed_adjustments = [];

        // 1. Fetch from stock counts
        $stock_query = DB::table('stock_count_items')
            ->join('stock_counts', 'stock_count_items.stock_count_id', '=', 'stock_counts.id')
            ->join('products', 'stock_count_items.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('CONCAT("SC-", stock_counts.id) as reference_no'),
                'stock_counts.updated_at as created_at',
                'products.name as product_name',
                'products.code as product_code',
                'stock_count_items.current_quantity',
                'stock_count_items.updated_quantity',
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name')
            )
            ->whereRaw('stock_count_items.updated_quantity != stock_count_items.current_quantity');

        if ($stock_count_id) {
            $stock_query->where('stock_count_items.stock_count_id', $stock_count_id);
        } else {
            $stock_query->whereDate('stock_counts.updated_at', '>=', $start_date)
                        ->whereDate('stock_counts.updated_at', '<=', $end_date)
                        ->where('stock_counts.is_resolved', true);
        }

        $stock_items = $stock_query->get();

        foreach ($stock_items as $item) {
            $diff = $item->updated_quantity - $item->current_quantity;
            $detailed_adjustments[] = (object)[
                'reference_no' => $item->reference_no,
                'created_at' => $item->created_at,
                'product_name' => $item->product_name,
                'product_code' => $item->product_code,
                'variant_name' => null,
                'qty' => abs($diff),
                'action' => $diff > 0 ? '+' : '-',
                'brand_name' => $item->brand_name
            ];
        }

        // 2. Fetch from manual product_adjustments if stock_count_id is NOT set
        if (!$stock_count_id) {
            $manual_items = DB::table('product_adjustments')
                ->join('adjustments', 'product_adjustments.adjustment_id', '=', 'adjustments.id')
                ->join('products', 'product_adjustments.product_id', '=', 'products.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('variants', 'product_adjustments.variant_id', '=', 'variants.id')
                ->select(
                    'adjustments.reference_no',
                    'adjustments.created_at',
                    'products.name as product_name',
                    'products.code as product_code',
                    'variants.name as variant_name',
                    'product_adjustments.qty',
                    'product_adjustments.action',
                    DB::raw('COALESCE(brands.title, "No Brand") as brand_name')
                )
                ->whereDate('adjustments.created_at', '>=', $start_date)
                ->whereDate('adjustments.created_at', '<=', $end_date)
                ->get();

            foreach ($manual_items as $item) {
                $detailed_adjustments[] = (object)[
                    'reference_no' => $item->reference_no,
                    'created_at' => $item->created_at,
                    'product_name' => $item->product_name,
                    'product_code' => $item->product_code,
                    'variant_name' => $item->variant_name,
                    'qty' => $item->qty,
                    'action' => $item->action,
                    'brand_name' => $item->brand_name
                ];
            }
        }

        // Sort by created_at desc
        usort($detailed_adjustments, function($a, $b) {
            return strcmp($b->created_at, $a->created_at);
        });

        return $detailed_adjustments;
    }
}

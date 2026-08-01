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
           $start_date = $request->input('start_date', date("Y-m-d", strtotime("-1 year")));
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
            $waste_data = $this->getGroupedWastes($start_date, $end_date, $stock_count_id, $stock_count_product_ids);
            $wastes_by_brand = $waste_data['wastes_by_brand'];
            $waste_total_qty = $waste_data['waste_total_qty'];
            $waste_total_revenue = $waste_data['waste_total_revenue'];
            $waste_total_cost = $waste_data['waste_total_cost'];

            // Fetch stock count specific metrics
            $stock_count_metrics = $this->getStockCountMetrics($stock_count_id);
            $stock_count_current_qty = $stock_count_metrics['stock_count_current_qty'];
            $stock_count_current_revenue = $stock_count_metrics['stock_count_current_revenue'];
            $stock_count_current_cost = $stock_count_metrics['stock_count_current_cost'];
            $stock_count_updated_qty = $stock_count_metrics['stock_count_updated_qty'];
            $stock_count_updated_revenue = $stock_count_metrics['stock_count_updated_revenue'];
            $stock_count_updated_cost = $stock_count_metrics['stock_count_updated_cost'];

            $stock_counts = DB::table('stock_counts')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();

            $stock_count_ids = $stock_counts->pluck('id')->toArray();
            
            $all_items = DB::table('stock_count_items')
                ->whereIn('stock_count_id', $stock_count_ids)
                ->get()
                ->groupBy('stock_count_id');

            $stock_count_list = [];
            foreach ($stock_counts as $sc) {
                $items = $all_items->get($sc->id, collect());
                $itemsGrouped = $items->groupBy('item_code');
                $stock_find = $items->sum('updated_quantity');
                $stock_increment = 0;
                $stock_decrement = 0;
                $current_stock = 0;
                foreach ($itemsGrouped as $group) {
                    $totalUpdated = $group->sum('updated_quantity');
                    $currentQty = $group[0]->current_quantity;
                    $current_stock += $currentQty;
                    if ($totalUpdated > $currentQty) {
                        $stock_increment += ($totalUpdated - $currentQty);
                    } elseif ($totalUpdated < $currentQty) {
                        $stock_decrement += ($currentQty - $totalUpdated);
                    }
                }
                
                $stock_count_list[] = (object)[
                    'id' => $sc->id,
                    'created_at' => $sc->created_at,
                    'current_stock' => $current_stock,
                    'stock_find' => $stock_find,
                    'stock_increment' => $stock_increment,
                    'stock_decrement' => $stock_decrement
                ];
            }

            return view('backend.report.overview_report', compact(
                'start_date', 'end_date', 'stock_count_id',
                'purchases_by_brand', 'purchase_total_qty', 'purchase_total_cost', 'purchase_total_selling_price',
                'sales_by_brand', 'sales_total_qty', 'sales_total_cost', 'sales_total_revenue',
                'purchase_returns_by_brand', 'purchase_return_total_qty', 'purchase_return_total_cost', 'purchase_return_total_selling_price',
                'sale_returns_by_brand', 'sale_returns_total_qty', 'sale_returns_total_cost', 'sale_returns_total_revenue',
                'wastes_by_brand', 'waste_total_qty', 'waste_total_revenue', 'waste_total_cost',
                'stock_count_current_qty', 'stock_count_current_revenue', 'stock_count_current_cost',
                'stock_count_updated_qty', 'stock_count_updated_revenue', 'stock_count_updated_cost',
                'stock_count_list'
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
                $sold_qty = $product_sale->sold_qty * $qty_list[$index];

                if (count($variant_list) && isset($variant_list[$index]) && $variant_list[$index]) {
                    $vKey = "{$sub_product_id}_{$variant_list[$index]}";
                    $averageCost = $variant_avg_cost[$vKey] ?? 0.0;
                } else {
                    $averageCost = $product_avg_cost[$sub_product_id] ?? 0.0;
                }

                $product_cost += $sold_qty * $averageCost;
            }
        } else {
            $sold_qty = $product_sale->sold_qty;
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
                DB::raw('SUM(product_sales.qty) as total_qty'),
                DB::raw('SUM(product_sales.qty * product_sales.net_unit_price) as total_revenue')
            )
            ->whereDate('sales.created_at', '>=', $start_date)
            ->whereDate('sales.created_at', '<=', $end_date);
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
     * Helper to load grouped waste totals
     */
    private function getGroupedWastes($start_date, $end_date, $stock_count_id, $stock_count_product_ids)
    {
        $wastes_by_brand = DB::table('waste_items')
            ->join('wastes', 'waste_items.waste_id', '=', 'wastes.id')
            ->join('products', 'waste_items.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw('COALESCE(brands.title, "No Brand") as brand_name'),
                DB::raw('SUM(waste_items.qty) as total_qty'),
                DB::raw('SUM(waste_items.qty * products.cost) as total_cost'),
                DB::raw('SUM(waste_items.qty * waste_items.unit_price) as total_revenue')
            )
            ->whereDate('wastes.created_at', '>=', $start_date)
            ->whereDate('wastes.created_at', '<=', $end_date);
        $wastes_by_brand = $wastes_by_brand->groupBy('brand_name')->get();

        $waste_total_qty = 0;
        $waste_total_cost = 0;
        $waste_total_revenue = 0;
        foreach ($wastes_by_brand as $w) {
            $waste_total_qty += $w->total_qty;
            $waste_total_cost += $w->total_cost;
            $waste_total_revenue += $w->total_revenue;
        }

        return [
            'wastes_by_brand' => $wastes_by_brand,
            'waste_total_qty' => $waste_total_qty,
            'waste_total_revenue' => $waste_total_revenue,
            'waste_total_cost' => $waste_total_cost
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
                ->leftJoin('product_variants', 'stock_count_items.item_code', '=', 'product_variants.item_code')
                ->leftJoin('products', function($join) {
                    $join->on('products.id', '=', 'product_variants.product_id')
                         ->orOn('products.code', '=', 'stock_count_items.item_code');
                })
                ->select(
                    DB::raw('SUM(stock_count_items.current_quantity) as current_qty'),
                    DB::raw('SUM(stock_count_items.current_quantity * COALESCE(products.price + product_variants.additional_price, products.price, 0)) as current_revenue'),
                    DB::raw('SUM(stock_count_items.current_quantity * COALESCE(products.cost + product_variants.additional_cost, products.cost, 0)) as current_cost'),
                    DB::raw('SUM(stock_count_items.updated_quantity) as updated_qty'),
                    DB::raw('SUM(stock_count_items.updated_quantity * COALESCE(products.price + product_variants.additional_price, products.price, 0)) as updated_revenue'),
                    DB::raw('SUM(stock_count_items.updated_quantity * COALESCE(products.cost + product_variants.additional_cost, products.cost, 0)) as updated_cost')
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
            'stock_count_updated_cost' => $stock_count_updated_cost,
        ];
    }
}

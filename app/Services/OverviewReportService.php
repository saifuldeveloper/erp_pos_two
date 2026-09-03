<?php

namespace App\Services;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\Product_Sale;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewReportService
{
    /**
     * Compute overview report data.
     *
     * @param Request $request
     * @return array
     */
    public function getOverviewReportData(Request $request): array
    {
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

        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();

        $product_sales_query = Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(DB::raw('product_sales.product_id, product_sales.product_batch_id, product_sales.sale_unit_id, sum(product_sales.qty) as sold_qty, sum(product_sales.return_qty) as return_qty, sum(product_sales.total) as sold_amount, COALESCE(brands.title, "No Brand") as brand_name'))
            ->whereDate('sales.created_at', '>=', $start_date)
            ->whereDate('sales.created_at', '<=', $end_date);

        $product_sale_data = $product_sales_query->groupBy('product_sales.product_id', 'product_sales.product_batch_id', 'brand_name')->get();

        $sale_returns_items = ProductReturn::join('returns', 'product_returns.return_id', '=', 'returns.id')
            ->join('products', 'product_returns.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(DB::raw('product_returns.product_id, product_returns.product_batch_id, product_returns.variant_id, sum(product_returns.qty) as sold_qty, 0 as return_qty, COALESCE(brands.title, "No Brand") as brand_name'))
            ->whereDate('returns.created_at', '>=', $start_date)
            ->whereDate('returns.created_at', '<=', $end_date);

        $sale_returns_items_data = $sale_returns_items->groupBy('product_returns.product_id', 'product_returns.product_batch_id', 'brand_name')->get();

        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();

        return compact(
            'start_date',
            'end_date',
            'stock_count_id',
            'product_sale_data',
            'sale_returns_items_data'
        );
    }
}

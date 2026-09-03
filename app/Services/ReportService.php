<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Returns;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get products that have fallen below their alert threshold.
     *
     * @return Collection
     */
    public function getProductQuantityAlerts(): Collection
    {
        return Product::select('name', 'code', 'image', 'qty', 'alert_quantity')
            ->where('is_active', true)
            ->whereColumn('alert_quantity', '>', 'qty')
            ->get();
    }

    /**
     * Get customer due report summary.
     *
     * @return array
     */
    public function getCustomerDueReportData(): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        return compact('lims_customer_list');
    }

    /**
     * Get supplier due report summary.
     *
     * @return array
     */
    public function getSupplierDueReportData(): array
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        return compact('lims_supplier_list');
    }

    /**
     * Get warehouse summary report data.
     *
     * @return Collection
     */
    public function getWarehouseList(): Collection
    {
        return Warehouse::where('is_active', true)->get();
    }
}

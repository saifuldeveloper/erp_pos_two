<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\PurchaseProductReturn;
use App\Models\ReturnPurchase;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\ReturnPurchaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ReturnPurchaseRepository extends BaseRepository implements ReturnPurchaseRepositoryInterface
{
    /**
     * ReturnPurchaseRepository constructor.
     *
     * @param ReturnPurchase $model
     */
    public function __construct(ReturnPurchase $model)
    {
        parent::__construct($model);
    }

    /**
     * Build base query with filters.
     */
    protected function buildFilteredQuery(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null)
    {
        $q = $this->model->newQuery();

        if (!empty($startDate)) {
            $q->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $q->whereDate('created_at', '<=', $endDate);
        }
        if (!empty($warehouseId)) {
            $q->where('warehouse_id', $warehouseId);
        }
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q;
    }

    /**
     * Count total return purchases matching warehouse and date filters.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function countTotalReturns(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null): int
    {
        return $this->buildFilteredQuery($warehouseId, $startDate, $endDate)->count();
    }

    /**
     * Get filtered return purchases for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredReturnsForDataTable(int $start, int $limit, string $order, string $dir, ?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): Collection
    {
        $q = $this->buildFilteredQuery($warehouseId, $startDate, $endDate)->with('supplier', 'warehouse', 'user');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('return_purchases.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('return_purchases.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered return purchases for DataTables.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredReturnsForDataTable(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): int
    {
        $q = $this->buildFilteredQuery($warehouseId, $startDate, $endDate);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('return_purchases.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('return_purchases.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Get products and details for a return purchase.
     *
     * @param int|string $returnId
     * @return array
     */
    public function getProductReturnDataByReturnId($returnId): array
    {
        $limsPurchaseProductReturnData = PurchaseProductReturn::with(['product', 'unit', 'productBatch', 'variant'])
            ->where('return_id', $returnId)
            ->get();
        $productReturn = [];

        foreach ($limsPurchaseProductReturnData as $key => $productReturnData) {
            $product = $productReturnData->product;
            if (!$product) {
                continue;
            }

            $unit = $productReturnData->unit;
            $unitName = $unit ? $unit->unit_name : '';

            $productBatch = $productReturnData->productBatch;
            $productVariant = $productReturnData->variant;

            $name = $product->name;
            $code = $product->code;
            if ($productVariant) {
                $name .= ' [' . $productVariant->name . ']';
            }
            if ($productReturnData->imei_number) {
                $name .= '<br>IMEI or Serial Numbers: ' . $productReturnData->imei_number;
            }

            $productReturn[0][$key] = $name;
            $productReturn[1][$key] = $code;
            $productReturn[2][$key] = $productReturnData->qty;
            $productReturn[3][$key] = $unitName;
            $productReturn[4][$key] = $productReturnData->tax;
            $productReturn[5][$key] = $productReturnData->tax_rate;
            $productReturn[6][$key] = $productReturnData->discount;
            $productReturn[7][$key] = $productReturnData->net_unit_cost;
            $productReturn[8][$key] = $productReturnData->total;
            $productReturn[9][$key] = $productBatch ? $productBatch->batch_no : '';
        }

        return $productReturn;
    }
}

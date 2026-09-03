<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductReturn;
use App\Models\ProductVariant;
use App\Models\Returns;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ReturnRepository extends BaseRepository implements ReturnRepositoryInterface
{
    /**
     * ReturnRepository constructor.
     *
     * @param Returns $model
     */
    public function __construct(Returns $model)
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
     * Count total sale returns matching warehouse and date filters.
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
     * Get filtered sale returns for DataTables.
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
        $q = $this->buildFilteredQuery($warehouseId, $startDate, $endDate)->with('biller', 'customer', 'user', 'warehouse');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('returns.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('returns.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered sale returns for DataTables.
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
                $query->whereDate('returns.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('returns.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Get products and details for a return modal.
     *
     * @param int|string $returnId
     * @return array
     */
    public function getProductReturnDataByReturnId($returnId): array
    {
        $limsProductReturnData = ProductReturn::where('return_id', $returnId)->get();
        $productReturn = [];

        foreach ($limsProductReturnData as $key => $productReturnData) {
            $product = Product::find($productReturnData->product_id);
            if (!$product) {
                continue;
            }

            $unit = Unit::find($productReturnData->sale_unit_id);
            $unitName = $unit ? $unit->unit_name : '';

            $productBatch = null;
            if ($productReturnData->product_batch_id) {
                $productBatch = ProductBatch::select('batch_no')->find($productReturnData->product_batch_id);
            }

            $productVariant = null;
            if ($productReturnData->variant_id) {
                $productVariant = Variant::find($productReturnData->variant_id);
            }

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
            $productReturn[7][$key] = $productReturnData->net_unit_price;
            $productReturn[8][$key] = $productReturnData->total;
            $productReturn[9][$key] = $productBatch ? $productBatch->batch_no : '';
        }

        return $productReturn;
    }
}

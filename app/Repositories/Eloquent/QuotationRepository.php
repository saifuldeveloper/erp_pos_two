<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductQuotation;
use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\QuotationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class QuotationRepository extends BaseRepository implements QuotationRepositoryInterface
{
    /**
     * QuotationRepository constructor.
     *
     * @param Quotation $model
     */
    public function __construct(Quotation $model)
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
     * Count total quotations matching warehouse and date filters.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function countTotalQuotations(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null): int
    {
        return $this->buildFilteredQuery($warehouseId, $startDate, $endDate)->count();
    }

    /**
     * Get filtered quotations for DataTables.
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
    public function getFilteredQuotationsForDataTable(int $start, int $limit, string $order, string $dir, ?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): Collection
    {
        $q = $this->buildFilteredQuery($warehouseId, $startDate, $endDate)->with('biller', 'customer', 'supplier', 'user', 'warehouse');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('quotations.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('quotations.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered quotations for DataTables.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredQuotationsForDataTable(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): int
    {
        $q = $this->buildFilteredQuery($warehouseId, $startDate, $endDate);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('quotations.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('quotations.reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Get products and details for a quotation modal.
     *
     * @param int|string $quotationId
     * @return array
     */
    public function getProductQuotationDataByQuotationId($quotationId): array
    {
        $limsProductQuotationData = ProductQuotation::with(['product', 'unit', 'productBatch', 'variant'])
            ->where('quotation_id', $quotationId)
            ->get();
        $productQuotation = [];

        foreach ($limsProductQuotationData as $key => $productQuotationData) {
            $product = $productQuotationData->product;
            if (!$product) {
                continue;
            }

            $unit = $productQuotationData->unit;
            $unitName = $unit ? $unit->unit_name : '';

            $productBatch = $productQuotationData->productBatch;
            $productVariant = $productQuotationData->variant;

            $name = $product->name;
            $code = $product->code;
            if ($productVariant) {
                $name .= ' [' . $productVariant->name . ']';
            }

            $productQuotation[0][$key] = $name;
            $productQuotation[1][$key] = $code;
            $productQuotation[2][$key] = $productQuotationData->qty;
            $productQuotation[3][$key] = $unitName;
            $productQuotation[4][$key] = $productQuotationData->tax;
            $productQuotation[5][$key] = $productQuotationData->tax_rate;
            $productQuotation[6][$key] = $productQuotationData->discount;
            $productQuotation[7][$key] = $productQuotationData->net_unit_price;
            $productQuotation[8][$key] = $productQuotationData->total;
            $productQuotation[9][$key] = $productBatch ? $productBatch->batch_no : '';
        }

        return $productQuotation;
    }
}

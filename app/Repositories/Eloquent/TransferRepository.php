<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductTransfer;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Tax;
use App\Models\Transfer;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\TransferRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferRepository extends BaseRepository implements TransferRepositoryInterface
{
    /**
     * TransferRepository constructor.
     *
     * @param Transfer $model
     */
    public function __construct(Transfer $model)
    {
        parent::__construct($model);
    }

    /**
     * Build base query with filters.
     */
    protected function buildFilteredQuery(array $filters)
    {
        $q = $this->model->newQuery();

        if (!empty($filters['starting_date'])) {
            $q->whereDate('created_at', '>=', $filters['starting_date']);
        }
        if (!empty($filters['ending_date'])) {
            $q->whereDate('created_at', '<=', $filters['ending_date']);
        }
        if (!empty($filters['from_warehouse_id'])) {
            $q->where('from_warehouse_id', $filters['from_warehouse_id']);
        }
        if (!empty($filters['to_warehouse_id'])) {
            $q->where('to_warehouse_id', $filters['to_warehouse_id']);
        }
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q;
    }

    /**
     * Count total transfers matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalTransfers(array $filters): int
    {
        return $this->buildFilteredQuery($filters)->count();
    }

    /**
     * Get filtered transfers for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param array $filters
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredTransfersForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null): Collection
    {
        $q = $this->buildFilteredQuery($filters)->with('fromWarehouse', 'toWarehouse', 'user');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('transfers.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered transfers for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredTransfersForDataTable(array $filters, ?string $searchValue = null): int
    {
        $q = $this->buildFilteredQuery($filters);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('transfers.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Get products and details for a transfer modal.
     *
     * @param int|string $transferId
     * @return array
     */
    public function getProductTransferDataByTransferId($transferId): array
    {
        $limsProductTransferData = ProductTransfer::where('transfer_id', $transferId)->get();
        $productTransfer = [];

        foreach ($limsProductTransferData as $key => $productTransferData) {
            $product = Product::find($productTransferData->product_id);
            if (!$product) {
                continue;
            }

            $unit = Unit::find($productTransferData->purchase_unit_id);
            $unitName = $unit ? $unit->unit_name : '';

            $productBatch = null;
            if ($productTransferData->product_batch_id) {
                $productBatch = ProductBatch::select('batch_no')->find($productTransferData->product_batch_id);
            }

            $productVariant = null;
            if ($productTransferData->variant_id) {
                $productVariant = Variant::find($productTransferData->variant_id);
            }

            $name = $product->name;
            $code = $product->code;
            if ($productVariant) {
                $name .= ' [' . $productVariant->name . ']';
            }

            $productTransfer[0][$key] = $name;
            $productTransfer[1][$key] = $code;
            $productTransfer[2][$key] = $productTransferData->qty;
            $productTransfer[3][$key] = $unitName;
            $productTransfer[4][$key] = $productTransferData->tax;
            $productTransfer[5][$key] = $productTransferData->tax_rate;
            $productTransfer[6][$key] = $productTransferData->subtotal;
            $productTransfer[7][$key] = $productBatch ? $productBatch->batch_no : '';
            $productTransfer[8][$key] = $productTransferData->net_unit_cost;
        }

        return $productTransfer;
    }

    /**
     * Search products for transfer screen.
     *
     * @param string $productCode
     * @param int $warehouseId
     * @return array
     */
    public function searchProductsForTransfer(string $productCode, int $warehouseId): array
    {
        $product = Product::where([
            ['code', $productCode],
            ['is_active', true]
        ])->first();

        $variant = null;
        if (!$product) {
            $variant = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.item_code', 'product_variants.additional_cost', 'product_variants.variant_id')
                ->where([
                    ['product_variants.item_code', $productCode],
                    ['products.is_active', true]
                ])->first();
        }

        return [$product, $variant];
    }
}

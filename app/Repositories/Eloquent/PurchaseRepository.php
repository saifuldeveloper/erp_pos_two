<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductPurchase;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PurchaseRepository extends BaseRepository implements PurchaseRepositoryInterface
{
    /**
     * PurchaseRepository constructor.
     *
     * @param Purchase $model
     */
    public function __construct(Purchase $model)
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
        if (!empty($filters['warehouse_id'])) {
            $q->where('warehouse_id', $filters['warehouse_id']);
        }
        if (!empty($filters['purchase_status'])) {
            $q->where('status', $filters['purchase_status']);
        }
        if (!empty($filters['payment_status'])) {
            $q->where('payment_status', $filters['payment_status']);
        }
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q;
    }

    /**
     * Count total purchases matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalPurchases(array $filters): int
    {
        return $this->buildFilteredQuery($filters)->count();
    }

    /**
     * Get filtered purchases for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param array $filters
     * @param string|null $searchValue
     * @param array $fieldNames
     * @return Collection
     */
    public function getFilteredPurchasesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null, array $fieldNames = []): Collection
    {
        $q = $this->buildFilteredQuery($filters)->with('supplier', 'warehouse');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue, $fieldNames) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");

                foreach ($fieldNames as $fieldName) {
                    $query->orWhere($fieldName, 'LIKE', "%{$searchValue}%");
                }
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered purchases for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredPurchasesForDataTable(array $filters, ?string $searchValue = null): int
    {
        $q = $this->buildFilteredQuery($filters);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Get products and product purchase details for a purchase.
     *
     * @param int|string $purchaseId
     * @return array
     */
    public function getProductPurchaseDataByPurchaseId($purchaseId): array
    {
        $limsProductPurchaseData = ProductPurchase::with(['product', 'unit', 'productBatch'])
            ->where('purchase_id', $purchaseId)
            ->get();
        $productPurchase = [];

        foreach ($limsProductPurchaseData as $key => $productPurchaseData) {
            $product = $productPurchaseData->product;
            if (!$product) {
                continue;
            }

            $unit = $productPurchaseData->unit;
            $unitCode = $unit ? ($unit->unit_code ?? $unit->unit_name) : 'N/A';
            $productBatch = $productPurchaseData->productBatch;

            $code = $product->code;
            if ($productPurchaseData->variant_id) {
                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('variant_id', $productPurchaseData->variant_id)
                    ->first();
                if ($variant && $variant->item_code) {
                    $code = $variant->item_code;
                }
            }

            $name = $product->name . ' [' . $code . ']';
            if ($productPurchaseData->imei_number) {
                $name .= '<br>IMEI or Serial Number: ' . $productPurchaseData->imei_number;
            }

            $productPurchase[0][$key] = $name;
            $productPurchase[1][$key] = $productPurchaseData->qty;
            $productPurchase[2][$key] = $unitCode;
            $productPurchase[3][$key] = $productPurchaseData->tax;
            $productPurchase[4][$key] = $productPurchaseData->tax_rate;
            $productPurchase[5][$key] = $productPurchaseData->discount;
            $productPurchase[6][$key] = $productPurchaseData->total;
            $productPurchase[7][$key] = $productBatch ? $productBatch->batch_no : 'N/A';
        }

        return $productPurchase;
    }

    /**
     * Search products for purchase screen.
     *
     * @param string $productCode
     * @param int|null $brandId
     * @return array
     */
    public function searchProductsForPurchase(string $productCode, ?int $brandId = null): array
    {
        $productQuery = Product::where([
            ['code', $productCode],
            ['is_active', true]
        ]);
        if ($brandId) {
            $productQuery->where('brand_id', $brandId);
        }
        $products = $productQuery->get();

        $variantQuery = Product::join('product_variants', 'products.id', 'product_variants.product_id')
            ->where([
                ['product_variants.item_code', $productCode],
                ['products.is_active', true]
            ]);
        if ($brandId) {
            $variantQuery->where('products.brand_id', $brandId);
        }
        $variants = $variantQuery->select('products.*', 'product_variants.item_code', 'product_variants.additional_cost', 'product_variants.variant_id')->get();

        return [$products, $variants];
    }
}

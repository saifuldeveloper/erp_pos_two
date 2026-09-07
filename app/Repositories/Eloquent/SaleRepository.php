<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Models\PaymentWithCheque;
use App\Models\PaymentWithCreditCard;
use App\Models\PaymentWithGiftCard;
use App\Models\PaymentWithPaypal;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Sale;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\Variant;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SaleRepository extends BaseRepository implements SaleRepositoryInterface
{
    /**
     * SaleRepository constructor.
     *
     * @param Sale $model
     */
    public function __construct(Sale $model)
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
        if (!empty($filters['sale_status'])) {
            $q->where('sale_status', $filters['sale_status']);
        }
        if (!empty($filters['payment_status'])) {
            $q->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['sale_type'])) {
            $q->where('sale_type', $filters['sale_type']);
        }
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q;
    }

    /**
     * Count total sales matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalSales(array $filters): int
    {
        return $this->buildFilteredQuery($filters)->count();
    }

    /**
     * Get filtered sales for DataTables.
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
    public function getFilteredSalesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null, array $fieldNames = []): Collection
    {
        $q = $this->buildFilteredQuery($filters)->with('biller', 'customer', 'warehouse', 'user');

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
     * Count filtered sales for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredSalesForDataTable(array $filters, ?string $searchValue = null): int
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
     * Get product sale details for a sale modal.
     *
     * @param int|string $saleId
     * @return array
     */
    public function getProductSaleDataBySaleId($saleId): array
    {
        $limsProductSaleData = Product_Sale::where('sale_id', $saleId)->get();
        $productSale = [];

        foreach ($limsProductSaleData as $key => $productSaleData) {
            $product = Product::find($productSaleData->product_id);
            if (!$product) {
                continue;
            }

            if ($productSaleData->variant_id) {
                $limsProductVariantData = ProductVariant::select('item_code')
                    ->FindExactProduct($productSaleData->product_id, $productSaleData->variant_id)
                    ->first();
                if ($limsProductVariantData) {
                    $product->code = $limsProductVariantData->item_code;
                }
            }

            $unitData = Unit::find($productSaleData->sale_unit_id);
            $unit = $unitData ? $unitData->unit_code : '';

            if ($productSaleData->product_batch_id) {
                $productBatchData = ProductBatch::select('batch_no')->find($productSaleData->product_batch_id);
                $batchNo = $productBatchData ? $productBatchData->batch_no : 'N/A';
            } else {
                $batchNo = 'N/A';
            }

            $name = $product->name . ' [' . $product->code . ']';
            if ($productSaleData->imei_number) {
                $name .= '<br>IMEI or Serial Number: ' . $productSaleData->imei_number;
            }

            $productSale[0][$key] = $name;
            $productSale[1][$key] = $productSaleData->qty;
            $productSale[2][$key] = $unit;
            $productSale[3][$key] = $productSaleData->tax;
            $productSale[4][$key] = $productSaleData->tax_rate;
            $productSale[5][$key] = $productSaleData->discount;
            $productSale[6][$key] = $productSaleData->total;
            $productSale[7][$key] = $batchNo;
            $productSale[8][$key] = $productSaleData->return_qty ?? 0;
            $productSale[9][$key] = $productSaleData->net_unit_price;
        }

        return $productSale;
    }

    /**
     * Get payments by sale id.
     *
     * @param int|string $saleId
     * @return array
     */
    public function getPaymentsBySaleId($saleId): array
    {
        $limsPaymentList = Payment::where('sale_id', $saleId)->get();
        $date = [];
        $paymentReference = [];
        $paidAmount = [];
        $payingMethod = [];
        $paymentId = [];
        $paymentNote = [];
        $chequeNo = [];
        $giftCardId = [];
        $change = [];
        $payingAmount = [];
        $accountName = [];
        $accountId = [];

        foreach ($limsPaymentList as $payment) {
            $date[] = date(config('date_format'), strtotime($payment->created_at->toDateString())) . ' ' . $payment->created_at->toTimeString();
            $paymentReference[] = $payment->payment_reference;
            $paidAmount[] = $payment->amount;
            $change[] = $payment->change;
            $payingMethod[] = $payment->paying_method;
            $payingAmount[] = $payment->amount + $payment->change;

            if ($payment->paying_method == 'Gift Card') {
                $giftCard = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                $giftCardId[] = $giftCard ? $giftCard->gift_card_id : null;
                $chequeNo[] = null;
            } elseif ($payment->paying_method == 'Cheque') {
                $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                $chequeNo[] = $cheque ? $cheque->cheque_no : null;
                $giftCardId[] = null;
            } else {
                $chequeNo[] = null;
                $giftCardId[] = null;
            }

            $paymentId[] = $payment->id;
            $paymentNote[] = $payment->payment_note;

            $account = Account::find($payment->account_id);
            $accountName[] = $account ? $account->name : 'N/A';
            $accountId[] = $account ? $account->id : null;
        }

        return [
            $date,
            $paymentReference,
            $paidAmount,
            $payingMethod,
            $paymentId,
            $paymentNote,
            $chequeNo,
            $giftCardId,
            $change,
            $payingAmount,
            $accountName,
            $accountId,
        ];
    }
}

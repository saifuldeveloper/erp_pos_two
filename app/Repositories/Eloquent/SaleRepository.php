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
        $limsProductSaleData = Product_Sale::with(['product', 'unit', 'productBatch', 'variant'])
            ->where('sale_id', $saleId)
            ->get();
        $productSale = [];

        foreach ($limsProductSaleData as $key => $productSaleData) {
            $product = $productSaleData->product;
            if (!$product) {
                continue;
            }

            $unit = $productSaleData->unit;
            $unitCode = $unit ? $unit->unit_code : '';

            $productBatch = $productSaleData->productBatch;
            $productVariant = $productSaleData->variant;

            $name = $product->name;
            $code = $product->code;
            if ($productVariant) {
                $name .= ' [' . $productVariant->name . ']';
            }
            if ($productSaleData->imei_number) {
                $name .= '<br>IMEI or Serial Numbers: ' . $productSaleData->imei_number;
            }

            $productSale[0][$key] = $name;
            $productSale[1][$key] = $code;
            $productSale[2][$key] = $productSaleData->qty;
            $productSale[3][$key] = $unitCode;
            $productSale[4][$key] = $productSaleData->tax;
            $productSale[5][$key] = $productSaleData->tax_rate;
            $productSale[6][$key] = $productSaleData->discount;
            $productSale[7][$key] = $productSaleData->net_unit_price;
            $productSale[8][$key] = $productSaleData->total;
            $productSale[9][$key] = $productBatch ? $productBatch->batch_no : '';
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
        $payments = Payment::where('sale_id', $saleId)->get();
        $paymentDate = [];
        $paymentReference = [];
        $paidAmount = [];
        $payingMethod = [];
        $paymentId = [];
        $paymentNote = [];
        $chequeNo = [];
        $giftCardId = [];
        $change = [];
        $payingAmount = [];
        $accountId = [];
        $account = [];
        $customerStripeId = [];

        foreach ($payments as $payment) {
            $paymentDate[] = date(config('date_format') ?: 'd-m-Y', strtotime($payment->created_at));
            $paymentReference[] = $payment->payment_reference;
            $paidAmount[] = $payment->amount;
            $change[] = $payment->change;
            $payingMethod[] = $payment->paying_method;
            $payingAmount[] = $payment->amount + $payment->change;
            $paymentId[] = $payment->id;
            $paymentNote[] = $payment->payment_note;
            $accountId[] = $payment->account_id;
            $account[] = $payment->account ? $payment->account->name : 'N/A';

            if ($payment->paying_method == 'Cheque') {
                $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                $chequeNo[] = $cheque ? $cheque->cheque_no : '';
            } else {
                $chequeNo[] = '';
            }

            if ($payment->paying_method == 'Gift Card') {
                $giftCard = PaymentWithGiftCard::where('payment_id', $payment->id)->first();
                $giftCardId[] = $giftCard ? $giftCard->gift_card_id : '';
            } else {
                $giftCardId[] = '';
            }

            if ($payment->paying_method == 'Credit Card') {
                $creditCard = PaymentWithCreditCard::where('payment_id', $payment->id)->first();
                $customerStripeId[] = $creditCard ? $creditCard->customer_stripe_id : '';
            } else {
                $customerStripeId[] = '';
            }
        }

        return [
            $paymentDate,
            $paymentReference,
            $paidAmount,
            $payingMethod,
            $paymentId,
            $paymentNote,
            $chequeNo,
            $giftCardId,
            $change,
            $payingAmount,
            $accountId,
            $account,
            $customerStripeId
        ];
    }
}

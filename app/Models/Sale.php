<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        "reference_no",
        "user_id",
        "cash_register_id",
        "table_id",
        "queue",
        "customer_id",
        "warehouse_id",
        "biller_id",
        "item",
        "total_qty",
        "total_discount",
        "total_tax",
        "total_price",
        "order_tax_rate",
        "order_tax",
        "order_discount_type",
        "order_discount_value",
        "order_discount",
        "coupon_id",
        "coupon_discount",
        "shipping_cost",
        "grand_total",
        "currency_id",
        "exchange_rate",
        "sale_status",
        "payment_status",
        "paid_amount",
        "document",
        "sale_note",
        "staff_note",
        'sale_type',
        "created_at",
        "woocommerce_order_id"
    ];

    public function biller()
    {
        return $this->belongsTo(Biller::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function productSales()
    {
        return $this->hasMany(Product_Sale::class);
    }

    public function isStatus(SaleStatus $status): bool
    {
        return (int) $this->sale_status === $status->value;
    }

    public function isPaymentStatus(PaymentStatus $status): bool
    {
        return (int) $this->payment_status === $status->value;
    }
}

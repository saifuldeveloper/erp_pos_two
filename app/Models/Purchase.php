<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        "reference_no",
        "user_id",
        "warehouse_id",
        "supplier_id",
        "currency_id",
        "exchange_rate",
        "item",
        "total_qty",
        "total_discount",
        "total_tax",
        "total_cost",
        "order_tax_rate",
        "order_tax",
        "order_discount",
        "shipping_cost",
        "grand_total",
        "paid_amount",
        "status",
        "payment_status",
        "document",
        "note",
        "created_at"
    ];

    public function productPurchases()
    {
        return $this->hasMany('App\Models\ProductPurchase');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function isStatus(PurchaseStatus $status): bool
    {
        return (int) $this->status === $status->value;
    }

    public function isPaymentStatus(PaymentStatus $status): bool
    {
        return (int) $this->payment_status === $status->value;
    }
}

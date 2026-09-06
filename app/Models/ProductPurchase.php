<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $table = 'product_purchases';

    protected $fillable = [
        "purchase_id",
        "product_id",
        "product_batch_id",
        "variant_id",
        "imei_number",
        "qty",
        "recieved",
        "purchase_unit_id",
        "net_unit_cost",
        "selling_price",
        "discount",
        "tax_rate",
        "tax",
        "total",
        "created_at",
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    public function productBatch()
    {
        return $this->belongsTo(ProductBatch::class, 'product_batch_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}

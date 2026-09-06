<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product_Sale extends Model
{
    protected $table = 'product_sales';
    protected $fillable = [
        "sale_id",
        "product_id",
        "product_batch_id",
        "variant_id",
        'imei_number',
        "qty",
        "return_qty",
        "sale_unit_id",
        "net_unit_price",
        "discount",
        "tax_rate",
        "tax",
        "total"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'sale_unit_id');
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

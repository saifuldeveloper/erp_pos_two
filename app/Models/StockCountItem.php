<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCountItem extends Model
{
    use HasFactory;

    protected $table = 'stock_count_items';

    protected $fillable = [
        'stock_count_id',
        'product_id',
        'item_code',
        'current_quantity',
        'updated_quantity'
    ];

    public function stockCount()
    {
        return $this->belongsTo(StockCount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'item_code', 'item_code');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'waste_id',
        'product_id',
        'qty',
        'unit_price',
        'subtotal'
    ];

    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

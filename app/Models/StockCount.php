<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
    protected $table = 'stock_counts';

    protected $fillable = [
        'warehouse_id',
        'is_completed',
        'is_resolved',
        'completed_by',
        'resolved_by',
    ];

    public function items()
    {
        return $this->hasMany(StockCountItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
    protected $table = 'stock_counts';

    protected $fillable = [
        'warehouse_id',
        'user_id',
        'note'
    ];

    public function items()
    {
        return $this->hasMany(StockCountItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

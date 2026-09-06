<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable =[

        "reference_no", "user_id", "status", "from_warehouse_id", "to_warehouse_id", "item", "total_qty", "total_tax", "total_cost", "shipping_cost", "grand_total", "document", "note", "created_at"
    ];

    public function fromWarehouse()
    {
    	return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
    	return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}

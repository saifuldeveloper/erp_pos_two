<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable =[
        "reference_no", "sale_id", "user_id", "address", "courier_id", "delivered_by", "recieved_by", "file", "status", "note" ,"courier_tracking_id"
    ];

    public function sale()
    {
    	return $this->belongsTo(Sale::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}

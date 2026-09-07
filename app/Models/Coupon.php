<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =[
        "code", "type", "amount", "minimum_amount", "user_id", "quantity", "used", "expired_date", "is_active"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

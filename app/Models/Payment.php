<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[
        "purchase_id", "user_id", "sale_id", "cash_register_id", "account_id", "payment_reference", "amount", "used_points","due_payment", "change", "paying_method", "payment_note"
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

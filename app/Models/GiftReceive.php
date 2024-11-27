<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'name',
        'quantity',
        'quantity_received',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

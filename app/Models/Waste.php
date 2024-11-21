<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver_type', // 'Employee', 'Customer', 'Supplier', 'Biller'
        'receiver_id',
        'receiver_name',
        'note',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(WasteItem::class);
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}

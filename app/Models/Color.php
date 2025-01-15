<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function products()
    {
        return Product::where(function ($query) {
            $query->where('variant_value', 'LIKE', '%' . $this->name . '%');
        });
    }
}

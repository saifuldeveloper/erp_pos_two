<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =[

        "name", 'image', "parent_id", "is_active", "is_sync_disable", "woocommerce_category_id"
    ];

    public function product()
    {
    	return $this->hasMany(Product::class);
    }

    public function parent()
    {
    	return $this->belongsTo(Category::class, 'parent_id');
    }

    public function child()
    {
    	return $this->hasMany(Category::class, 'parent_id');
    }
}

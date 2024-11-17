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
    	return $this->hasMany('App\Models\Product');
    }

    public function parent()
    {
    	return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function child()
    {
    	return $this->hasMany('App\Models\Category', 'parent_id');
    }
}

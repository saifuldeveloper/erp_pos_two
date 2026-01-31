<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ["name","is_active","client_id","client_secret","store_id","username","password"];
}

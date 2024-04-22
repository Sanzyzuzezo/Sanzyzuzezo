<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StoreStock extends Authenticatable
{
    protected $table = 'store_stock';
    protected $fillable = ['id', 'item_variant_id', 'store_id', 'stock'];
}
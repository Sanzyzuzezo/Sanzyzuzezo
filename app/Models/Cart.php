<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cart extends Authenticatable
{
    use Notifiable;

    protected $table = 'carts';
    protected $fillable = ['id', 'customer_id', 'product_id', 'product_variant_id', 'quantity', 'created_at', 'updated_at'];
}

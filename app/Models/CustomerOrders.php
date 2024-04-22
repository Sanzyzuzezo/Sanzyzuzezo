<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrders extends Model
{
    use HasFactory;

    protected $guard = 'customer_orders';

    protected $fillable = [
        'customer_group_id', 'name'
    ];
}

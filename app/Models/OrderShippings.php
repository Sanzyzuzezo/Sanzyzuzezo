<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderShippings extends Authenticatable
{
    protected $table = 'order_shippings';
    protected $fillable = ['id', 'resi', 'order_id', 'type', 'courier', 'service', 'weight', 'dimensions', 'distance', 'cost', 'address'];
}

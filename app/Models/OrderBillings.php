<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderBillings extends Authenticatable
{
    protected $table = 'order_billings';
    protected $fillable = ['id', 'payment_method', 'order_id', 'data', 'total_bayar', 'change','status', 'payment_method_id', 'payment_method_details_id'];
}

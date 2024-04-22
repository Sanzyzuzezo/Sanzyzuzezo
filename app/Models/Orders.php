<?php

namespace App\Models;

use App\Models\OrderItems;
use App\Models\OrderBillings;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Orders extends Authenticatable
{
    protected $table = 'orders';
    protected $fillable = ['id', 'customer_id', 'invoice_number', 'status', 'transaction_date', 'discount', 'tax','discount_order','total', 'note', 'name', 'email', 'phone', 'old_total', 'sub_total','customer_email', 'user_id', 'customer_order_id', 'total_item', 'store_id', 'flag_pos', 'jenis_discount', 'discount_price', 'cash_register_id','company_id','payment_due_at'];

    public function OrderItems(){
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function OrderBillings(){
        return $this->hasOne(OrderBillings::class, 'order_id');
    }
}

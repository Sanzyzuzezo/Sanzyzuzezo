<?php

namespace App\Models;

use App\Models\PaymentMethodDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guard = 'payment_methods';

    protected $fillable = [
        'name'
    ];

    public function PaymentMethodDetails(){
        return $this->hasMany(PaymentMethodDetail::class, 'payment_method_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodDetail extends Model
{
    use HasFactory;

    protected $guard = 'payment_method_details';

    protected $fillable = [
        'payment_method_id', 'name'
    ];
}

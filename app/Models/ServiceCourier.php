<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCourier extends Model
{
    use HasFactory;
    protected $table = 'service_courier';
    protected $fillable = ['courier_id', 'code', 'title'];
}

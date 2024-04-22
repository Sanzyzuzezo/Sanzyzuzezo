<?php

namespace App\Models;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'province_id', 'city_id', 'subdistrict_id', 'detail_address', 'received_name', 'received_phone', 'active', 'deleted_by'];

      /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}

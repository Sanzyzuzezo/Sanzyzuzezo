<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model {

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'code','image', 'province_id', 'city_id', 'subdistrict_id', 'detail_address', 'status',
    'deleted_by','company_id'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function store_detail()
    {
        return $this->hasMany(StoreDetail::class, 'store_id');
    }
}

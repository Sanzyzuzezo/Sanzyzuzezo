<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model {

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'code','contact_pic','pic_phone','detail_address', 'status', 'note','city_id','company_id','deleted_by',];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}

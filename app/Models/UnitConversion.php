<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitConversion extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'unit_conversions';
    protected $fillable = ['id', 'item_variant_id', 'unit_id', 'quantity', 'new_quantity', 'new_unit', 'status', 'created_at','deleted_by','company_id'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Warehouse extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'warehouses';
    protected $fillable = ['id', 'code', 'name', 'pic', 'status','deleted_by', 'company_id', 'accurate_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

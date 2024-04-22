<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreDetail extends Model {

    use HasFactory, SoftDeletes;
    protected $table = 'store_detail';
    protected $fillable = ['id', 'store_id', 'warehouse_id','deleted_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

}
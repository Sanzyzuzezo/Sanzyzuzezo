<?php

namespace App\Models;

use App\Models\AdjusmentDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Adjusment extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'adjusment';

    protected $fillable = ['id', 'date', 'warehouse_id','deleted_by', 'company_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function adjusment_detail()
    {
        return $this->hasMany(AdjusmentDetail::class, 'adjusment_id');
    }
}
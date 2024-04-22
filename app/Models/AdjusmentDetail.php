<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdjusmentDetail extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'adjusment_detail';

    protected $fillable = ['id', 'adjusment_id', 'item_id', 'item_variant_id', 'current_stock', 'new_stock', 'difference', 'note', 'deleted_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
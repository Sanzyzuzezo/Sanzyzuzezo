<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductionDetail extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'production_details';
    protected $guarded = ['id'];
}

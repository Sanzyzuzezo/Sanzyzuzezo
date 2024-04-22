<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{   
    use SoftDeletes;
    protected $table = 'brands';
    // protected $fillable = ['id', 'name', 'image', 'status', 'created_at', 'updated_at'];
    protected $guarded = [];
        
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guard = 'pages';

    protected $fillable = [
        'title', 'description', 'meta_title', 'meta_description', 'status', 'image', 'same_as_default', 'title_an', 'description_an',
        'deleted_by', 'company_id'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at']; 

}

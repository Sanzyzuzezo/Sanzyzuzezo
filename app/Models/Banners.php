<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banners extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guard = 'banners';

    protected $fillable = [
        'title', 'caption', 'description', 'same_as_default', 'title_an', 'caption_an', 'description_an', 'show_button', 'button_text', 'button_url', 'status', 'image', 'date', 'posisi_banner', 'created_at',
        'deleted_by', 'company_id'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}

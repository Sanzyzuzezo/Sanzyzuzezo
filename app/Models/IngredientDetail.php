<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class IngredientDetail extends Authenticatable
{
    use SoftDeletes;
    
    protected $table = 'ingredient_details';
    protected $guarded = ['id'];
}

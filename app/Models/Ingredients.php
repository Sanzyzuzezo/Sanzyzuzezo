<?php

namespace App\Models;

use App\Models\IngredientDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ingredients extends Authenticatable
{

    use SoftDeletes;

    protected $table = 'ingredients';
    protected $guarded = ['id'];
    public $timestamps = true;
    
    public function ingredient_details()
    {
        return $this->hasMany(IngredientDetail::class, 'ingredient_id');
    }
}

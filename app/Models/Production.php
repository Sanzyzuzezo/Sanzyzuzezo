<?php

namespace App\Models;

use App\Models\ProductionDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Production extends Authenticatable
{
    use SoftDeletes;
    
    protected $table = 'productions';
    protected $guarded = ['id'];

    public function production_detail()
    {
        return $this->hasMany(ProductionDetail::class, 'production_id');
    }
}

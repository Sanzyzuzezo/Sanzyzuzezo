<?php

namespace App\Models;

use App\Models\StockCardDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StockCard extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'stock_card';
    
    protected $fillable = ['id', 'date', 'transaction_type', 'warehouse_id', 'destination_warehouse_id', 'store_id', 'status', 'canceled_at', 'deleted_by', 'company_id'];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function stock_card_detail()
    {
        return $this->hasMany(StockCardDetail::class, 'stock_card_id');
    }
}
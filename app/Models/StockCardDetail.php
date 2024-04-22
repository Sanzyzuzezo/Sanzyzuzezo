<?php

namespace App\Models;

use App\Models\StockCard;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StockCardDetail extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'stock_card_detail';

    protected $fillable = ['id', 'stock_card_id', 'item_variant_id', 'quantity', 'quantity_after_conversion', 'unit_id', 'canceled_at','deleted_by'];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function stock_card()
    {
        return $this->belongsTo(StockCard::class, 'stock_card_id');
    }
}
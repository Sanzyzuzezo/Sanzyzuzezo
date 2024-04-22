<?php

namespace App\Models;

use App\Models\PromotionProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promotions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'id',
        'type',
        'title',
        'start_at',
        'start_date',
        'end_date',
        'discount_type',
        'discount_value',
        'image',
        'status',
        'note',
        'deleted_by',
        'company_id'
	];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function promotion_product()
    {
        return $this->hasMany(PromotionProduct::class, 'promotion_id');
    }
}

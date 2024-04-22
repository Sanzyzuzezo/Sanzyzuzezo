<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_variants';

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
        'product_id',
        'supplier_id',
        'sku',
        'name',
        'description',
        'weight',
        'dimensions',
        'price',
        'minimal_stock',
        'stock',
        'status',
        'discount_price',
        'unit_id',
        'sale',
        'bought',
        'ingredient',
        'show_online_shop',
        'show_pos',
        'production',
        'deleted_by'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $hidden = ["created_at", "updated_at", "created_by", "updated_by"];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

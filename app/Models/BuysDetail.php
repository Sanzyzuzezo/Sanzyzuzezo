<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuysDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 
     *
     * @var string
     */
    protected $table = 'buys_detail';

    /**
     * 
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * 
     *
     * @var array
     */
    protected $fillable = [
        'buys_id',
        'product_variant_id',
        'harga',
        'jumlah',
        'quantity_after_conversion',
        'unit_id',
        'total',
        'image',
        'expired',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_by',
    ];

    /**
     * 
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 
     *
     * @param mixed
     * @return void
     */

    public function buys()
    {
        return $this->belongsTo(Buys::class, 'buys_id', 'id');
    }
}

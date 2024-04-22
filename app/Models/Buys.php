<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buys extends Model
{
    use HasFactory, SoftDeletes;

    /**
     *
     *
     * @var string
     */
    protected $table = 'buys';

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
        'tanggal',
        'supplier_id',
        'warehouse_id',
        'total_item',
        'total_keseluruhan',
        'nomor_pembelian',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_by',
        'company_id'
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
    public function buysDetail()
    {
        return $this->hasMany(BuysDetail::class, 'buys_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Models\Brands;
use App\Models\Category;
use App\Models\ProductMedia;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $guarded = [];
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'supplier_id',
        'brand_id',
        'category_id',
        'name',
        'description',
        'status',
        'deleted_by',
        'company_id'
	];
     
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $hidden = ["created_at", "updated_at","created_by", "updated_by"];

    public function images()
    {
        return $this->hasMany(ProductMedia::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}

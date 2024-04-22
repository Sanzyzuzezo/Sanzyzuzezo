<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'parent',
        'name',
        'image',
        'status',
        'deleted_by',
        'company_id'
    ];

    protected $hidden = ["created_at", "updated_at","created_by", "updated_by"];
        
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent')->with('categories');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
}


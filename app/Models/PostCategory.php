<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_categories';

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
        'name',
        'same_as_default',
        'name_an',
        'slug',
        'meta_title',
        'meta_description',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_by',
        'company_id'
	];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at']; 

    /**
     * Get the posts for the category.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id', 'id');
    }
}

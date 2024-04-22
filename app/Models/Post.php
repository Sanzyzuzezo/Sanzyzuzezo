<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
        'post_category_id',
        'title',
        'description',
        'same_as_default',
        'title_an',
        'description_an',
        'data_file',
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
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    } 
}

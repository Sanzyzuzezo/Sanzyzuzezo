<?php

namespace App\Models;

use App\Models\CustomerGroup;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerGroupCategories extends Authenticatable
{
    use SoftDeletes;
    
    protected $table = 'customer_group_categories';
    
    protected $fillable = ['id', 'customer_group_id', 'category_id', 'discount', 'status', 'deleted_by'];

      /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function customer_group()
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }
}

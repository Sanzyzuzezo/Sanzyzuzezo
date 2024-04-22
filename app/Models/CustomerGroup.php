<?php

namespace App\Models;

use App\Models\CustomerGroupCategories;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerGroup extends Authenticatable
{
    use SoftDeletes;
    
    protected $table = 'customer_groups';
    protected $fillable = ['id', 'customer_group_id', 'name', 'email', 'address', 'phone', 'password', 'status', 'company_id'];

      /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function customer_group_categories()
    {
        return $this->hasMany(CustomerGroupCategories::class, 'customer_group_id');
    }
}

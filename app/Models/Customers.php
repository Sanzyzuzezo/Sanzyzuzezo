<?php

namespace App\Models;

use App\Models\CustomerAddress;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customers extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $guard = 'customers';

    protected $fillable = [
        'customer_group_id', 'name', 'email', 'address', 'phone', 'password', 'remember_token', 'status', 'image',
        'deleted_by','company_id', 'default_address_id'
    ];

    protected $hidden = [
        'remember_token',
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function customer_addres()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }
}

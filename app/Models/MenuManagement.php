<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Harimayco\Menu\Models\Menus;
use Harimayco\Menu\Models\MenuItems;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuManagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admin_menus';

    protected $fillable = ['id', 'name'];

    public function Menus()
    {
        return $this->hasMany(Menus::class, 'id', 'menu');
    }

    public function MenuItems()
    {
        return $this->hasMany(MenuItems::class, 'id', 'menu');
    }


}

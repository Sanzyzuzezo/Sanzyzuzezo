<?php

namespace App\Models;

use App\Models\SalesDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $guarded = ['id'];

    public function detail(){
        return $this->hasMany(SalesDetail::class, 'sales_id');
    }
}

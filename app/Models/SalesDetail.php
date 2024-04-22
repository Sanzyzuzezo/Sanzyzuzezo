<?php

namespace App\Models;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales_detail';

    protected $guarded = ['id'];

    public function master(){
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }
}

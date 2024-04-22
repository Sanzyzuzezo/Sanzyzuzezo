<?php

namespace App\Models;

use App\Models\InvoiceSales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceSalesDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice_sales_detail';

    protected $guarded = ['id'];

    public function master(){
        return $this->belongsTo(InvoiceSales::class, 'invoice_sales_id', 'id');
    }
}

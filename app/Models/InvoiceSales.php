<?php

namespace App\Models;

use App\Models\InvoiceSalesDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceSales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice_sales';

    protected $guarded = ['id'];

    public function detail(){
        return $this->hasMany(InvoiceSalesDetail::class, 'invoice_sales_id');
    }
}

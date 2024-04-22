<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cash_in_hand',
        'status',
        'total_cash',
        'note',
        'closed_at',
        'closed_by',
        'total_tunai'
	];
    
}

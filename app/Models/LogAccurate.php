<?php

namespace App\Models;

use App\Models\LogAccurateDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogAccurate extends Model
{
    use HasFactory;

    protected $table = 'log_accurate';

    protected $guarded = ['id'];
}

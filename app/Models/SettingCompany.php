<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCompany extends Model
{
    use HasFactory;

       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings_companies';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'name',
        'value',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'company_id'
	];  
}

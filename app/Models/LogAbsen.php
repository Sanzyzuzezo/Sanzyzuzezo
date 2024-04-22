<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAbsen extends Model
{
    use HasFactory;

    protected $table = 'log_absen';

    // protected $fillable = ['id','id_karyawan', 'jam_masuk','jam_keluar','telat','path_image_masuk','path_image_keluar','nama_file_masuk','nama_file_keluar','status'];
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_karyawan');
    }
}

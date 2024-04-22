<?php

namespace App\Models;

use App\Models\DeliveryNoteDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery_note';

    protected $guarded = ['id'];

    public function detail(){
        return $this->hasMany(DeliveryNoteDetail::class, 'delivery_note_id', 'id');
    }
}

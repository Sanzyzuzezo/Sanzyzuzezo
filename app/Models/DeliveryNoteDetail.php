<?php

namespace App\Models;

use App\Models\DeliveryNote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryNoteDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery_note_detail';

    protected $guarded = ['id'];

    public function master(){
        return $this->belongsTo(DeliveryNote::class, 'delivery_note_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraduacionAttachment extends Model
{
    use HasFactory;

    protected $table = 'graduaciones_attachments';

    protected $fillable = [
        'graduacion_id',
        'type',
        'value',
        'file_name',
        'display_order',
    ];

    public function graduacion()
    {
        return $this->belongsTo(Graduacion::class, 'graduacion_id');
    }
}

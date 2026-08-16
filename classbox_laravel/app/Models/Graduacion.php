<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduacion extends Model
{
    use HasFactory;

    protected $table = 'graduaciones';

    protected $fillable = [
        'user_id',
        'title',
        'synopsis',
        'main_image',
        'video_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(GraduacionAttachment::class, 'graduacion_id')->orderBy('display_order', 'asc');
    }
}

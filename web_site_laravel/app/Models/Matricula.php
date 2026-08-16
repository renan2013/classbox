<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'programa',
        'nacionalidad',
        'codigo_pais',
        'email',
        'whatsapp',
        'foto',
        'documentos',
        'fecha_nacimiento',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
}

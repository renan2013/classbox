<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $table = 'home_sections';

    protected $fillable = [
        'section_key',
        'name',
        'title',
        'subtitle',
        'order',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'settings' => 'array',
    ];
}

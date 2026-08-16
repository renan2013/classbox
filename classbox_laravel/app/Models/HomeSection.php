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

    protected $appends = ['icon'];

    public function getIconAttribute(): string
    {
        return match ($this->section_key) {
            'slider' => 'fa-solid fa-panorama text-teal-600',
            'categories' => 'fa-solid fa-tags text-indigo-600',
            'featured_posts' => 'fa-solid fa-graduation-cap text-purple-600',
            'testimonials' => 'fa-solid fa-comment-dots text-amber-500',
            'graduaciones' => 'fa-solid fa-images text-rose-500',
            'portfolio' => 'fa-solid fa-briefcase text-teal-600',
            'cta_banner' => 'fa-solid fa-bullhorn text-emerald-600',
            'custom_content' => 'fa-solid fa-code text-blue-500',
            default => 'fa-solid fa-cube text-slate-500',
        };
    }
}

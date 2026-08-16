<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'mobile_image_path',
        'button_text',
        'button_url',
        'overlay_style',
        'content_alignment',
        'content_vertical_alignment',
        'title_color',
        'title_size',
        'subtitle_color',
        'title_weight',
        'font_family',
        'button_style',
        'show_subtitle',
        'show_title',
        'show_button',
        'order',
        'is_active',
        'start_date',
        'end_date',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_subtitle' => 'boolean',
        'show_title' => 'boolean',
        'show_button' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = ['image_url', 'mobile_image_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        return $this->mobile_image_path ? asset('storage/' . $this->mobile_image_path) : $this->image_url;
    }
}

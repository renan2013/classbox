<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientData extends Model
{
    use HasFactory;

    protected $table = 'client_data';

    protected $fillable = [
        'company_name',
        'website_url',
        'logo_path',
        'favicon_path',
        'logo_dark_path',
        'whatsapp_country_code',
        'whatsapp_number',
        'phone',
        'email',
        'address',
        'schedule_info',
        'google_maps_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
        'linkedin_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'google_analytics_id',
        'meta_pixel_id',
        'custom_head_scripts',
        'custom_body_scripts',
        'maintenance_mode',
        'maintenance_message',
        'maintenance_bypass_key',
        'primary_color',
        'secondary_color',
        'topbar_bg_color',
        'topbar_text_color',
        'navbar_bg_color',
        'navbar_text_color',
        'footer_bg_color',
        'footer_text_color',
        'card_bg_color',
        'card_border_color',
        'slider_overlay_style',
        'slider_content_alignment',
        'slider_content_vertical_alignment',
        'slider_title_color',
        'slider_title_size',
        'slider_subtitle_color',
        'slider_default_subtitle',
        'slider_default_title',
        'slider_default_button_text',
        'slider_default_button_url',
        'slider_title_weight',
        'slider_font_family',
        'slider_button_style',
        'slider_show_subtitle',
        'slider_show_title',
        'slider_show_button',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'slider_show_subtitle' => 'boolean',
        'slider_show_title' => 'boolean',
        'slider_show_button' => 'boolean',
    ];

    protected $appends = [
        'logo_url',
        'favicon_url',
        'logo_dark_url',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon_path ? asset('storage/' . $this->favicon_path) : null;
    }

    public function getLogoDarkUrlAttribute(): ?string
    {
        return $this->logo_dark_path ? asset('storage/' . $this->logo_dark_path) : null;
    }
}

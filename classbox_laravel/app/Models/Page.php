<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'is_published',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected $appends = ['featured_image_url', 'public_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    public function getPublicUrlAttribute(): string
    {
        $baseUrl = env('FRONTEND_URL', 'http://127.0.0.1:8080');
        return rtrim($baseUrl, '/') . '/' . $this->slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            } else {
                $page->slug = Str::slug($page->slug);
            }
        });
    }
}

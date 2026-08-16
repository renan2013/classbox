<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'synopsis',
        'content',
        'main_image',
        'order',
        'instructor_name',
        'instructor_title',
        'instructor_photo',
        'show_in_instructors',
        'is_published',
    ];

    protected $casts = [
        'show_in_instructors' => 'boolean',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected $appends = [
        'main_image_url',
        'slider_image_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'post_id')->orderBy('display_order', 'asc');
    }

    public function getMainImageUrlAttribute(): ?string
    {
        return $this->main_image ? asset('storage/' . $this->main_image) : null;
    }

    public function getSliderImageAttachmentAttribute(): ?Attachment
    {
        return $this->attachments->firstWhere('type', 'slider_image');
    }

    public function getSliderImageUrlAttribute(): ?string
    {
        $slider = $this->attachments->firstWhere('type', 'slider_image');
        return $slider && $slider->value ? asset('storage/' . $slider->value) : null;
    }
}

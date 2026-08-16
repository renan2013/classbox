<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $table = 'media_files';

    protected $fillable = [
        'name',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'dimensions',
        'alt_text',
        'user_id',
    ];

    protected $appends = ['url', 'formatted_size', 'icon'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        } elseif ($bytes > 0) {
            return $bytes . ' B';
        }
        return '0 B';
    }

    public function getIconAttribute(): string
    {
        return match ($this->file_type) {
            'image' => 'fa-solid fa-image text-teal-500',
            'document' => 'fa-solid fa-file-pdf text-rose-500',
            'video' => 'fa-solid fa-film text-purple-500',
            'audio' => 'fa-solid fa-music text-amber-500',
            'archive' => 'fa-solid fa-file-zipper text-blue-500',
            default => 'fa-solid fa-file text-slate-400',
        };
    }
}

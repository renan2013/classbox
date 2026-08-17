<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'display_order',
        'parent_id',
        'target',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('display_order', 'asc');
    }

    public static function tree()
    {
        return static::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->orderBy('display_order', 'asc');
            }])
            ->orderBy('display_order', 'asc')
            ->get();
    }
}

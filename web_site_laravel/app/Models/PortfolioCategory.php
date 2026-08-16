<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioCategory extends Model
{
    use HasFactory;

    protected $table = 'portfolio_categories';

    protected $fillable = [
        'name',
        'slug',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PortfolioItem::class, 'category_id')->orderBy('order', 'asc');
    }
}

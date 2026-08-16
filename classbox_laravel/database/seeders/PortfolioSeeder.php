<?php

namespace Database\Seeders;

use App\Models\PortfolioCategory;
use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Logos', 'slug' => 'logos', 'order' => 1, 'is_active' => true],
            ['name' => 'Website', 'slug' => 'website', 'order' => 2, 'is_active' => true],
            ['name' => 'Impresiones', 'slug' => 'impresiones', 'order' => 3, 'is_active' => true],
            ['name' => 'Varios', 'slug' => 'varios', 'order' => 4, 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            PortfolioCategory::updateOrInsert(['slug' => $cat['slug']], $cat);
        }
    }
}

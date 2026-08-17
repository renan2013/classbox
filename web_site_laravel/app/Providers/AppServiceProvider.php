<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ClientData;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('client_data')) {
                View::composer('*', function ($view) {
                    $client_data = ClientData::first();
                    $categories = Category::withCount('posts')->get();
                    $site_menus = Menu::with(['children' => fn($q) => $q->where('is_active', true)->orderBy('display_order', 'asc')])
                        ->whereNull('parent_id')
                        ->where('is_active', true)
                        ->orderBy('display_order', 'asc')
                        ->get();

                    $view->with('client_data', $client_data)
                         ->with('categories', $categories)
                         ->with('site_menus', $site_menus);
                });
            }
        } catch (\Throwable $e) {
            // Silently fallback if running commands or migrations
        }
    }
}

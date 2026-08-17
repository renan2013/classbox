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
        View::composer('*', function ($view) {
            try {
                $client_data = null;
                $categories = collect();
                $site_menus = collect();

                if (Schema::hasTable('client_data')) {
                    $client_data = ClientData::first();
                }

                if (Schema::hasTable('categories')) {
                    $categories = Category::withCount('posts')->get();
                }

                if (Schema::hasTable('menus')) {
                    $hasActive = Schema::hasColumn('menus', 'is_active');
                    $query = Menu::whereNull('parent_id')->orderBy('display_order', 'asc');
                    
                    if ($hasActive) {
                        $query->where('is_active', true);
                        $query->with(['children' => fn($q) => $q->where('is_active', true)->orderBy('display_order', 'asc')]);
                    } else {
                        $query->with(['children' => fn($q) => $q->orderBy('display_order', 'asc')]);
                    }
                    
                    $site_menus = $query->get();
                }

                $view->with('client_data', $client_data)
                     ->with('categories', $categories)
                     ->with('site_menus', $site_menus);
            } catch (\Throwable $e) {
                $view->with('client_data', null)
                     ->with('categories', collect())
                     ->with('site_menus', collect());
            }
        });
    }
}

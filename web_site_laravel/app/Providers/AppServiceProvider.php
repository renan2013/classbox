<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ClientData;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

if (!function_exists('site_url')) {
    function site_url(?string $path = null): string
    {
        if (empty($path)) {
            $base = rtrim(request()->getBaseUrl(), '/');
            return request()->getSchemeAndHttpHost() . ($base ?: '');
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || $path === '#') {
            return $path;
        }
        $base = rtrim(request()->getBaseUrl(), '/');
        return request()->getSchemeAndHttpHost() . $base . '/' . ltrim($path, '/');
    }
}

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
        // Auto-verificar y crear columna is_active en menus si aún no existe en producción
        try {
            if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'is_active')) {
                Schema::table('menus', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('target');
                });
                \App\Models\Menu::whereNull('is_active')->update(['is_active' => true]);
            }
        } catch (\Throwable $e) {
            // Silencioso
        }

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

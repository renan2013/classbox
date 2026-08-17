<?php

namespace App\Providers;

use App\Models\ClientData;
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
        // Auto-verificar y crear columna is_active en menus si aún no existe en producción
        try {
            if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'is_active')) {
                Schema::table('menus', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('target');
                });
                \App\Models\Menu::whereNull('is_active')->update(['is_active' => true]);
            }
        } catch (\Throwable $e) {
            // Silencioso si ya existe o hay concurrencia
        }

        // Compartir datos institucionales del cliente con todas las vistas Blade
        View::composer('*', function ($view) {
            static $clientData = null;
            if ($clientData === null) {
                try {
                    if (Schema::hasTable('client_data')) {
                        $clientData = ClientData::first();
                    }
                } catch (\Throwable $e) {
                    $clientData = null;
                }
            }
            $view->with('clientData', $clientData);
        });
    }
}

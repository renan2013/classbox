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

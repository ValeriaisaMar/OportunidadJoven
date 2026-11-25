<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
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
        // En Render (producción) todo el sitio se sirve por HTTPS
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Fechas relativas en español ("hace 2 días") en todas las páginas
        Carbon::setLocale('es');
    }
}

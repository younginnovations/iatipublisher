<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || config('app.env') === 'staging') {
            \URL::forceScheme('https');
        }

        Horizon::auth(function ($request) {
            // Always show admin if local development
            if (env('APP_ENV') === 'local') {
                return true;
            }
        });
    }
}

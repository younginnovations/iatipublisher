<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        // $this->app->bind(
        //   'App\IATI\Repositories\RepositoryInterface',
        //   'App\IATI\Repositories\Repository'
        // );
    }
}

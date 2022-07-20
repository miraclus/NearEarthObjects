<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NasaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nasaService', 'App\Services\NasaService\Nasa');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace KamilKoscielniak\EloquentFilters;

use Illuminate\Support\ServiceProvider;

class EloquentFiltersProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/filters.php' => config_path('filters.php')
        ], 'config');
    }
}

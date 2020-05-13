<?php

namespace KamilKoscielniak\EloquentFilters;

use Illuminate\Support\ServiceProvider;

class EloquentFiltersProvider extends ServiceProvider
{
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

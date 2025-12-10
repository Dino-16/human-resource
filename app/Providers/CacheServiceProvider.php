<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->useCachePath(storage_path('framework/cache'));
    }

    public function boot()
    {
        //
    }
}

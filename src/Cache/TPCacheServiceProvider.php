<?php

namespace TPFoundation\Cache;

use TPFoundation\Cache\TPCacheManager;
use Illuminate\Support\ServiceProvider;
use Stash;

/**
 * Class TPCacheServiceProvider
 * @package App\Providers
 */
class TPCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->bind('tpcache', function() {

            $stash = new TPCacheManager();
            return $stash;
        });
    }
}

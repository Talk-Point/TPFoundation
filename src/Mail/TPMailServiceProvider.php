<?php

namespace TPFoundation\Mail;

use TPFoundation\Cache\TPCacheManager;
use Illuminate\Support\ServiceProvider;
use Stash;

/**
 * Class TPMailServiceProvider
 * @package App\Providers
 */
class TPMailServiceProvider extends ServiceProvider
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

<?php /** Log Manager */

namespace TPFoundation\Log;

use Illuminate\Support\ServiceProvider;
use TPFoundation\Log\TPLogManager;

class TPLogServiceProvider extends ServiceProvider
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

        $app->bind('tplog', function() {
            return new TPLogManager();
        });
    }
}

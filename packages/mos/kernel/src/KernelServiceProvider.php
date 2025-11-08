<?php
namespace Mos\Kernel;

use Illuminate\Support\ServiceProvider;

class KernelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('mos.kernel', function($app){
            return new KernelCore($app);
        });

        $this->mergeConfigFrom(__DIR__.'/../config/mos.php','mos');
    }

    public function boot()
    {
        // load package migrations and routes if any
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // initialize kernel
        $this->app->make('mos.kernel')->init();
    }
}
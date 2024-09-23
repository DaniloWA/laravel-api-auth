<?php

namespace Danilowa\LaravelApiAuth\Providers;

use Illuminate\Support\ServiceProvider;

class ApiAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/apiauth.php', 'apiauth');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}

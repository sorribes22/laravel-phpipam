<?php

namespace Axsor\PhpIPAM;

use Illuminate\Support\ServiceProvider;

class PhpIPAMServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/phpipam.php' => base_path('config/phpipam.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('phpipam', function () {
            return new PhpIPAM();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/phpipam.php', 'phpipam');
    }
}

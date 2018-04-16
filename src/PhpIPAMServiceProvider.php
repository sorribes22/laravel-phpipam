<?php

namespace Axsor\LaravelPhpIPAM;


use Illuminate\Support\ServiceProvider;

class PhpIPAMServiceProvider extends ServiceProvider
{

    /**
     * @var string Name with which the file will be created
     */
    protected $configFile = 'phpipam.php';

    /**
     * @var string Path to package configuration file
     */
    protected $configPath = '/../config/phpipam.php';



    public function boot()
    {
        $this->publishes([
            __DIR__ . $this->configPath => config_path($this->configFile),
            'config'
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('phpipam', function () {
            return new PhpIPAM;
        });
    }
}

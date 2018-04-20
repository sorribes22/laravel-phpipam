<?php

namespace Axsor\LaravelPhpIPAM;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class PhpIPAMServiceProvider extends ServiceProvider
{

    /**
     * @var string Path to package configuration file
     */
    protected $configPath = '/../config/phpipam.php';


    /**
     * Registering PhpIPAM config without publishing it
     */
    public function boot()
    {
        if ($this->app['config']->get('phpipam') === null)
        {
            $this->app['config']->set('phpipam', require __DIR__ . $this->configPath);
        }
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

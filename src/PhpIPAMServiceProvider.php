<?php

namespace Axsor\LaravelPhpIPAM;


use Illuminate\Support\Facades\Log;
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


    /**
     * Registering PhpIPAM config without publishing it
     */
    public function boot()
    {
//        if ($this->app['config']->get('phpipam'))
//        {
        if ($this->app['config']->get('phpipam') === null) {
            $this->app['config']->set('phpipam', require __DIR__ . '/../config/phpipam.php');
        }
//        }
//        else Log::error('Cannot register PhpIPAM config file because same name is catched!');
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

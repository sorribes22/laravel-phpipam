<?php

namespace Axsor\LaravelPhpIPAM;


use Illuminate\Support\Facades\Facade;

class PhpIPAMFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'phpipam';
    }
}

<?php

namespace Axsor\PhpIPAM\Facades;

use Illuminate\Support\Facades\Facade;

class PhpIPAM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'phpipam';
    }
}

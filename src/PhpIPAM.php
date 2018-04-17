<?php

namespace Axsor\LaravelPhpIPAM;


use Axsor\LaravelPhpIPAM\Requests\SubnetRequest;
use Axsor\LaravelPhpIPAM\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class PhpIPAM
{
//    private static $connection = 'default';

//    public function use ($connection)
//    {
//        self::$connection = $connection;
//
//        return $this;
//    }

    public static function subnet ($subnet)
    {
        return (new SubnetRequest())->subnet($subnet);
    }

//    public static function authenticate ()
//    {
//        return (new UserRequest())->authenticate();
//    }
}

<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Illuminate\Support\Facades\Log;

class UserRequest extends Connection
{
    public function __construct($connection = 'default')
    {
        parent::__construct($connection);
    }

    public static function authenticate()
    {
        Log::info(parent::post('user/', ['username' => parent::$user, 'password' => parent::$pass]));
    }
}
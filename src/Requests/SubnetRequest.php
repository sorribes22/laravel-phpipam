<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Illuminate\Support\Facades\Log;

class SubnetRequest extends Connection
{

    public function __construct($connection = 'default')
    {
        parent::__construct($connection);
    }

    public function subnet($id)
    {
        $result = parent::get('subnets/' . $id . '/');
        Log::info($result);
        return $result;
    }
}
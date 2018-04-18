<?php

namespace Axsor\LaravelPhpIPAM;


use Axsor\LaravelPhpIPAM\Requests\SubnetRequest;
use Axsor\LaravelPhpIPAM\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class PhpIPAM
{

    /*##################################################################################################################
     *###############################################------ SUBNET ------###############################################
     *################################################################################################################*/
    public static function subnet ($subnet)
    {
        return (new SubnetRequest)->subnet($subnet);
    }

    public static function subnetUsage ($subnet)
    {
        return (new SubnetRequest())->usage($subnet);
    }

    public static function subnetFirstIPFree($subnet)
    {
        return (new SubnetRequest())->firstIPFree($subnet);
    }

    public static function subnetSlaves($subnet)
    {
        return (new SubnetRequest())->slaves($subnet);
    }

    public static function subnetAddresses($subnet)
    {
        return (new SubnetRequest())->addresses($subnet);
    }

    public static function subnetAddress($subnet, $ip)
    {
        return (new SubnetRequest())->address($subnet, $ip);
    }
}

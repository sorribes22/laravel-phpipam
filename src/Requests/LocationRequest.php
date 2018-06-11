<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Axsor\LaravelPhpIPAM\Models\Locations\LocationCollection;
use Axsor\LaravelPhpIPAM\Models\Subnets\SubnetCollection;

class LocationRequest extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function locations()
    {
        return new LocationCollection(parent::get("tools/locations/")['data']);
    }

    /**
     * Return all subnets of specific location
     *
     * @param $location
     * @return SubnetCollection
     */
    public function subnets($location)
    {
        return new SubnetCollection(parent::get("tools/locations/{$location}/subnets/")['data']);
    }

    /**
     * Return all devices of specific location
     * // TODO create device collection and model
     * @param $location
     * @return mixed
     */
    public function devices($location)
    {
        return parent::get("tools/locations/{$location}/devices/");
    }

    /**
     * Return all racks of specific location
     * // TODO create rack collection and model
     * @param $location
     * @return mixed
     */
    public function racks($location)
    {
        return parent::get("tools/locations/{$location}/racks/");
    }
}
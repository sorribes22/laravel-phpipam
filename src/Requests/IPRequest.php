<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Axsor\LaravelPhpIPAM\Models\IPs\IP;
use Axsor\LaravelPhpIPAM\Models\Subnets\Subnet;
use Axsor\LaravelPhpIPAM\Models\Tags\TagCollection;

class IPRequest extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Create a new ip address using the first free ip found in subnet.
     *
     * Can pass subnet object or id of subnet.
     * And ip object (excepting some parametters like 'id', 'subnetId' or 'ip') or array with data.
     *
     * @param $subnet
     * @param $ip
     * @return mixed
     */
    public function createFirstFree($subnet, $ip)
    {
        $subnet_id = $subnet;

        if (get_class($subnet) == Subnet::class)
        {
            $subnet_id = $subnet->id;
        }

        return parent::post("addresses/first_free/{$subnet_id}/", $ip);
    }

    /**
     * Create a new ip address giving all data (including 'subnetId' and 'ip')
     *
     * @param $ip IP|array
     * @return mixed
     */
    public function create($ip)
    {
        return parent::post("addresses/", $ip);
    }

    /**
     * Get all tags available for IPs
     *
     * @return TagCollection
     */
    public function tags()
    {
        return new TagCollection(parent::get("addresses/tags/")['data']);
    }
}
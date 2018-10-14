<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Axsor\LaravelPhpIPAM\Models\IPs\IP;
use Axsor\LaravelPhpIPAM\Models\IPs\IPCollection;
use Axsor\LaravelPhpIPAM\Models\Subnets\Subnet;
use Axsor\LaravelPhpIPAM\Models\Tags\TagCollection;
use Illuminate\Support\Facades\Log;

class IPRequest extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return IP
     *
     * @param $ip
     * @return IP
     */
    public function address($ip)
    {
        return new IP(parent::get("addresses/{$ip}/")['data']);
    }


    public function byHostname($hostname)
    {
        return parent::get("addresses/search_hostname/{$hostname}/");
    }

    public function search($ip)
    {
        $response = parent::get("addresses/search/{$ip}/");

        return array_key_exists('data', $response) ? new IPCollection($response) : null;
    }

    /**
     * Returns true if address responds
     *
     * @param $ip
     * @return bool
     */
    public function ping($ip)
    {
        return parent::get("addresses/{$ip}/ping/")['data']['result_code'] === "SUCCESS";
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

        if (gettype($subnet) == "object")
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
     * Updates address. Return true if updates it successful
     *
     * @param $ip_id
     * @param $ip
     * @return bool
     */
    public function edit($ip_id, $ip)
    {
        return parent::patch("addresses/{$ip_id}/", $ip)['message'] === "Address updated";
    }

    /**
     * Delete address
     *
     * @param $ip
     * @return mixed
     */
    public function drop($ip)
    {
        $ip_id = $ip;

        if (gettype($ip) == "object")
        {
            $ip_id = $ip->id;
        }

        return parent::delete("addresses/{$ip_id}/")['message'] === "Address deleted";
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

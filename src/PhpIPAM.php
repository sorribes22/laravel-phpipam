<?php

namespace Axsor\PhpIPAM;

use GuzzleHttp\Client;
use Axsor\PhpIPAM\Http\Requests\AddressRequest;
use Axsor\PhpIPAM\Http\Controllers\AddressController;

class PhpIPAM
{
    private $config;

    private $client;

    public function __construct()
    {
        $this->config = config('phpipam');
        $this->client = new Client;
    }

    /**
     * Set custom config to connect to PhpIPAM.
     *
     * @param array $config
     * @return $this
     */
    public function use(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Unset custom config to connect to PhpIPAM.
     * Config will be read from your environment.
     *
     * @return $this
     */
    public function useDefaultConfig()
    {
        $this->config = config('phpipam');

        return $this;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getClient()
    {
        return $this->client;
    }

    // ADDRESSES CONTROLLER
    public function address($id)
    {
        return (new AddressController)->show($id);
    }

    public function ping($id)
    {
        return (new AddressController)->ping($id);
    }

    public function searchIp(string $ip)
    {
        return (new AddressController)->searchIp($ip);
    }

    public function searchHostname(string $hostname)
    {
        return (new AddressController)->searchHostname($hostname);
    }

    public function customFields()
    {
        return (new AddressController)->customFields();
    }

    public function tags()
    {
        return (new AddressController)->tags();
    }

    public function tag($tag)
    {
        return (new AddressController)->tag($tag);
    }

    public function tagAddresses($tag)
    {
        return (new AddressController)->tagAddresses($tag);
    }

    public function addressCreate(array $address)
    {
        return (new AddressController)->create($address);
    }

    public function addressUpdate($address, array $newData)
    {
        return (new AddressController)->update($address, $newData);
    }

    public function addressDrop($address)
    {
        return (new AddressController)->drop($address);
    }

    public function addressRaw($address)
    {
        return (new AddressRequest)->show($address);
    }
}

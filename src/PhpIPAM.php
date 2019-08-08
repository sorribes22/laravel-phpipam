<?php

namespace Axsor\PhpIPAM;

use Axsor\PhpIPAM\Http\Controllers\AddressController;

class PhpIPAM
{
    private $config;

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
    public function useDefault()
    {
        $this->config = null;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    // ADDRESSES CONTROLLER
    public function address(int $id)
    {
        return (new AddressController)->show($id);
    }

    public function ping(int $id)
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

    public function tag(int $id)
    {
        return (new AddressController)->tag($id);
    }

    public function tagAddresses(int $id)
    {
        return (new AddressController)->tagAddresses($id);
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
}

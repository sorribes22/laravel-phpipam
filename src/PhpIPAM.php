<?php

namespace Axsor\PhpIPAM;

use Axsor\PhpIPAM\Http\Controllers\SectionController;
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

    // WRAPPED DATA
    // ADDRESSES CONTROLLER
    public function address($address)
    {
        return (new AddressController)->show($address);
    }

    public function ping($address)
    {
        return (new AddressController)->ping($address);
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

    // SECTION CONTROLLER
    public function sections()
    {
        return (new SectionController)->index();
    }

    public function section($section)
    {
        return (new SectionController)->show($section);
    }

    public function sectionSubnets($section)
    {
        return (new SectionController)->subnets($section);
    }

    public function sectionByName(string $section)
    {
        return (new SectionController)->byName($section);
    }

    // TODO upgrade PhpIPAM from 1.3 to 1.5
    //public function sectionCustomFields()
    //{
    //    return (new SectionController)->customFields();
    //}

    public function sectionCreate(array $section)
    {
        return (new SectionController)->create($section);
    }

    public function sectionUpdate($section, array $newData)
    {
        return (new SectionController)->update($section, $newData);
    }

    public function sectionDrop($section)
    {
        return (new SectionController)->drop($section);
    }



    // RAW DATA
    // ADDRESS REQUEST
    public function addressRaw($address)
    {
        return (new AddressRequest)->show($address);
    }

    public function pingRaw($address)
    {
        return (new AddressRequest)->ping($address);
    }

    public function searchIpRaw(string $ip)
    {
        return (new AddressRequest)->searchIp($ip);
    }

    public function searchHostnameRaw(string $hostname)
    {
        return (new AddressRequest)->searchHostname($hostname);
    }

    public function customFieldsRaw()
    {
        return (new AddressRequest)->customFields();
    }

    public function tagsRaw()
    {
        return (new AddressRequest)->tags();
    }

    public function tagRaw($tag)
    {
        return (new AddressRequest)->tag($tag);
    }

    public function tagAddressesRaw($tag)
    {
        return (new AddressRequest)->tagAddresses($tag);
    }

    public function addressCreateRaw(array $address)
    {
        return (new AddressRequest)->create($address);
    }

    public function addressUpdateRaw($address, array $newData)
    {
        return (new AddressRequest)->update($address, $newData);
    }

    public function addressDropRaw($address)
    {
        return (new AddressRequest)->drop($address);
    }
}

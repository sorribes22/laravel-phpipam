<?php

namespace Axsor\PhpIPAM;

use Axsor\PhpIPAM\Http\Controllers\SubnetController;
use GuzzleHttp\Client;
use Axsor\PhpIPAM\Http\Requests\AddressRequest;
use Axsor\PhpIPAM\Http\Controllers\AddressController;
use Axsor\PhpIPAM\Http\Controllers\SectionController;

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

    public function addressByIp(string $ip)
    {
        return (new AddressController)->byIp($ip);
    }

    public function addressByHostname(string $hostname)
    {
        return (new AddressController)->byHostname($hostname);
    }

    public function addressCustomFields()
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

    // SUBNET CONTROLLER
    public function subnet($subnet)
    {
        return (new SubnetController)->show($subnet);
    }

    public function subnetUsage($subnet)
    {
        return (new SubnetController)->usage($subnet);
    }

    public function subnetFreeAddress($subnet)
    {
        return (new SubnetController)->freeAddress($subnet);
    }

    public function subnetSlaves($subnet)
    {
        return (new SubnetController)->slaves($subnet);
    }

    public function subnetSlavesRecursive($subnet)
    {
        return (new SubnetController)->slavesRecursive($subnet);
    }

    public function subnetAddresses($subnet)
    {
        return (new SubnetController)->addresses($subnet);
    }

    public function subnetIp($subnet, string $ip)
    {
        return (new SubnetController)->ip($subnet, $ip);
    }

    public function subnetFreeSubnet($subnet, int $mask)
    {
        return (new SubnetController)->freeSubnet($subnet, $mask);
    }

    public function subnetFreeSubnets($subnet, int $mask)
    {
        return (new SubnetController)->freeSubnets($subnet, $mask);
    }

    public function subnetCustomFields()
    {
        return (new SubnetController)->customFields();
    }

    public function subnetByCidr(string $cidr)
    {
        return (new SubnetController)->byCidr($cidr);
    }

    public function subnetCreate(array $data)
    {
        return (new SubnetController)->create($data);
    }

    public function subnetCreateInSubnet($subnet, array $data)
    {
        return (new SubnetController)->createInSubnet($subnet, $data);
    }

    public function subnetUpdate($subnet, array $newData)
    {
        return (new SubnetController)->update($subnet, $newData);
    }

    public function subnetResize($subnet, int $mask)
    {
        return (new SubnetController)->resize($subnet, $mask);
    }

    public function subnetSplit($subnet, int $number)
    {
        return (new SubnetController)->split($subnet, $number);
    }

    public function subnetDrop($subnet)
    {
        return (new SubnetController)->drop($subnet);
    }

    public function subnetTruncate($subnet)
    {
        return (new SubnetController)->truncate($subnet);
    }

    // TODO subnet permissions (PATCH & DELETE)

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
}

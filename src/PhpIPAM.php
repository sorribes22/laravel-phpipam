<?php

namespace Axsor\PhpIPAM;

use Axsor\PhpIPAM\Http\Controllers\AddressController;
use Axsor\PhpIPAM\Http\Controllers\DeviceController;
use Axsor\PhpIPAM\Http\Controllers\SectionController;
use Axsor\PhpIPAM\Http\Controllers\SubnetController;
use Axsor\PhpIPAM\Http\Controllers\ToolController;
use Axsor\PhpIPAM\Http\Controllers\CircuitController;
use Axsor\PhpIPAM\Http\Requests\AddressRequest;
use GuzzleHttp\Client;

class PhpIPAM
{
    private $connection = 'default';

    private $config;

    private $client;

    public function __construct()
    {
        $this->client = new Client();

        $this->resetConfig();
    }

    /**
     * Change phpipam server we want to connect to.
     * @param $connection
     * @return $this
     */
    public function connect($connection)
    {
        $this->connection = $connection;

        return $this->resetConfig();
    }

    /**
     * Reset phpipam connection to default.
     * @return $this
     */
    public function resetConnection()
    {
        $this->connection = 'default';

        return $this->resetConfig();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getCacheKey()
    {
        return 'phpipam-'.$this->connection;
    }

    /**
     * Set custom config to connect to PhpIPAM.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        $this->reconfigClient();

        return $this;
    }

    /**
     * Unset custom config to connect to PhpIPAM.
     * Config will be read from your environment.
     *
     * @return $this
     */
    public function resetConfig()
    {
        $this->config = config('phpipam')[$this->connection];

        $this->reconfigClient();

        return $this;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    private function reconfigClient()
    {
        if (is_object($this->client) && $this->client instanceof Client) {
            $this->client = new Client(['verify' => $this->config['verify_cert']]);
        }
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

    public function addressTags()
    {
        return (new AddressController)->tags();
    }

    public function addressTag($tag)
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

    public function addressCreateFirstFree($subnet)
    {
        return (new AddressController)->createFirstFree($subnet);
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

    // DEVICE CONTROLLER

    public function devices()
    {
        return (new DeviceController)->index();
    }

    public function device($device)
    {
        return (new DeviceController)->show($device);
    }

    public function deviceSubnets($device)
    {
        return (new DeviceController)->subnets($device);
    }

    public function deviceAddresses($device)
    {
        return (new DeviceController)->addresses($device);
    }

    public function deviceCreate(array $device)
    {
        return (new DeviceController)->create($device);
    }

    public function deviceUpdate($device, array $newData)
    {
        return (new DeviceController)->update($device, $newData);
    }

    public function deviceDrop($device)
    {
        return (new DeviceController)->drop($device);
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

    public function locations()
    {
        return (new ToolController)->locations();
    }

    public function location($location)
    {
        return (new ToolController)->location($location);
    }

    public function locationCreate(array $location)
    {
        return (new ToolController)->locationCreate($location);
    }

    public function locationUpdate($location, array $newData)
    {
        return (new ToolController)->locationUpdate($location, $newData);
    }

    public function locationDrop($location)
    {
        return (new ToolController)->locationDrop($location);
    }

    public function tags()
    {
        return (new ToolController)->tags();
    }

    public function tag($tag)
    {
        return (new ToolController)->tag($tag);
    }

    public function tagCreate(array $tag)
    {
        return (new ToolController)->tagCreate($tag);
    }

    public function tagUpdate($tag, array $newData)
    {
        return (new ToolController)->tagUpdate($tag, $newData);
    }

    public function tagDrop($tag)
    {
        return (new ToolController)->tagDrop($tag);
    }

    public function deviceTypes()
    {
        return (new ToolController)->deviceTypes();
    }

    // CIRCUITS

    public function circuits()
    {
        return (new CircuitController)->index();
    }

    public function circuit($circuit)
    {
        return (new CircuitController)->show($circuit);
    }

    public function circuitCreate(array $circuit)
    {
        return (new CircuitController)->create($circuit);
    }

    public function circuitUpdate($circuit, array $newData)
    {
        return (new CircuitController)->update($circuit, $newData);
    }

    public function circuitDrop($circuit)
    {
        return (new CircuitController)->drop($circuit);
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
}

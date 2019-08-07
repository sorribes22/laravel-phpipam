<?php

namespace Axsor\PhpIPAM;

<<<<<<< HEAD
=======
use GuzzleHttp\Client;
>>>>>>> 5d63f247fcfa2553c8d0c407116eee193690d74e
use Axsor\PhpIPAM\Http\Controllers\AddressController;

class PhpIPAM
{
    protected $config;

    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

    public function address(int $id)
    {
        return (new AddressController($this->config))->show($id);
    }

    public function ping(int $id)
    {
        return (new AddressController($this->config))->ping($id);
    }

    public function searchIp(string $ip)
    {
        return (new AddressController($this->config))->searchIp($ip);
    }

    public function searchHostname(string $hostname)
    {
        return (new AddressController($this->config))->searchHostname($hostname);
    }

    public function customFields()
    {
        return (new AddressController($this->config))->customFields();
    }

    public function tags()
    {
        return (new AddressController($this->config))->tags();
    }

    public function tag(int $id)
    {
        return (new AddressController($this->config))->tag($id);
    }

    public function addressesOfTag(int $id)
    {
        return (new AddressController($this->config))->addressesOfTag($id);
    }
}

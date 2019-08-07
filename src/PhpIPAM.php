<?php

namespace Axsor\PhpIPAM;

use GuzzleHttp\Client;
use Axsor\PhpIPAM\Http\Controllers\AddressController;

class PhpIPAM
{
    protected $config;

    public function __construct(array $config = null)
    {
        //$connector = new Connector();
        $this->config = $config;
    }

    //public function address(int $id)
    //{
    //    $response = $this->client->get(self::API_ENDPOINT."addresses/$id/");
    //
    //    $address = json_encode($response->getBody()->getContents());
    //
    //    return $address;
    //}

    public function address(int $id)
    {
        return (new AddressController($this->config))->show($id);
    }
}

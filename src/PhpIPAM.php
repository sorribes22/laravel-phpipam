<?php

namespace Axsor\PhpIPAM;

use GuzzleHttp\Client;

class PhpIPAM
{
    const API_ENDPOINT = 'http://phpipam.com/api/app/';
    protected $client;

    public function __construct(Client $client = null)
    {
        //$connector = new Connector();
        $this->client = $client ?: new Client();
    }

    public function address(int $id)
    {
        $response = $this->client->get(self::API_ENDPOINT."addresses/$id/");

        $address = json_encode($response->getBody()->getContents());
//echo "\nANTES DEL ECHO\n";
//echo $address;
//echo "\nDESPRES DEL ECHO\n";
        return $address;
    }
}

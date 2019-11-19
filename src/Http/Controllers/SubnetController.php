<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\SubnetRequest;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Data;
use Axsor\PhpIPAM\Models\Subnet;

class SubnetController
{
    protected $request;

    public function __construct()
    {
        $this->request = new SubnetRequest;
    }

    public function show($subnet)
    {
        $response = $this->request->show($subnet);

        return new Subnet($response['data']);
    }

    public function usage($subnet)
    {
        $response = $this->request->usage($subnet);

        return new Data($response['data']);
    }

    public function freeAddress($subnet)
    {
        $response = $this->request->freeAddress($subnet);

        return get_key_or_null($response, 'data');
    }

    public function slaves($subnet)
    {
        $response = $this->request->slaves($subnet);

        return response_to_collect($response, Subnet::class);
    }

    public function slavesRecursive($subnet)
    {
        $response = $this->request->slavesRecursive($subnet);

        return response_to_collect($response, Subnet::class);
    }

    public function addresses($subnet)
    {
        $response = $this->request->addresses($subnet);

        return response_to_collect($response, Address::class);
    }

    public function ip($subnet, string $ip)
    {
        $response = $this->request->ip($subnet, $ip);

        return response_to_collect($response, Address::class);
    }

    public function freeSubnet($subnet, int $mask)
    {
        $response = $this->request->freeSubnet($subnet, $mask);

        return get_key_or_null($response);
    }

    public function freeSubnets($subnet, int $mask)
    {
        $response = $this->request->freeSubnets($subnet, $mask);

        return response_to_collect($response);
    }

    public function customFields()
    {
        $response = $this->request->customFields();

        return response_to_collect($response, CustomField::class);
    }

    public function byCidr(string $cidr)
    {
        $response = $this->request->byCidr($cidr);

        return response_to_collect($response, Subnet::class);
    }

    public function create(array $data)
    {
        $response = $this->request->create($data);

        return get_key_or_null($response, 'id');
    }

    public function createInSubnet($subnet, array $data)
    {
        $response = $this->request->createInSubnet($subnet, $data);

        return get_key_or_null($response, 'id');
    }

    public function update($subnet, array $newData)
    {
        $response = $this->request->update($subnet, $newData);

        return (bool) $response['success'];
    }

    public function resize($subnet, int $mask)
    {
        $response = $this->request->resize($subnet, $mask);

        return (bool) $response;
    }

    public function split($subnet, int $number)
    {
        $response = $this->request->split($subnet, $number);

        return (bool) $response['success'];
    }

    public function drop($subnet)
    {
        $response = $this->request->drop($subnet);

        return (bool) $response['success'];
    }

    public function truncate($subnet)
    {
        $response = $this->request->truncate($subnet);

        return (bool) $response['success'];
    }
}

<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\DeviceRequest;
use Axsor\PhpIPAM\Models\Device;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Section;
use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Models\Location;
use Axsor\PhpIPAM\Models\Circuit;

class DeviceController
{
    protected $request;

    public function __construct()
    {
        $this->request = new DeviceRequest;
    }

    public function index()
    {
        $response = $this->request->index();

        return response_to_collect($response, Device::class);
    }

    public function show($device)
    {
        $response = $this->request->show($device);

        return new Device($response['data']);
    }

    public function types($device)
    {
        $response = $this->request->types();

        return response_to_collect($response, Device::class);
    }

    public function subnets($device)
    {
        $response = $this->request->subnets($device);

        return response_to_collect($response, Subnet::class);
    }

    public function addresses($device)
    {
        $response = $this->request->addresses($device);

        return response_to_collect($response, Address::class);
    }

    public function create(array $device)
    {
        $response = $this->request->create($device);

        return get_key_or_null($response, 'id');
    }

    public function update($device, array $newData)
    {
        $response = $this->request->update($device, $newData);

        return (bool) $response['success'];
    }

    public function drop($device)
    {
        $response = $this->request->drop($device);

        return (bool) $response['success'];
    }
}

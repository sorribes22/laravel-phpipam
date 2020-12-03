<?php

namespace Axsor\PhpIPAM\Http\Requests;

class DeviceRequest extends Connector
{
    public function index()
    {
        return $this->get('devices');
    }

    public function show($device)
    {
        $id = get_id_from_variable($device);

        return $this->get("devices/{$id}");
    }

    public function subnets($device)
    {
        $id = get_id_from_variable($device);

        return $this->get("devices/{$id}/subnets");
    }

    public function addresses($device)
    {
        $id = get_id_from_variable($device);

        return $this->get("devices/{$id}/addresses");
    }

    public function create(array $device)
    {
        return $this->post('devices', $device);
    }

    public function update($device, array $newData)
    {
        $id = get_id_from_variable($device);

        return $this->patch("devices/{$id}", $newData);
    }

    public function drop($device)
    {
        $id = get_id_from_variable($device);

        return $this->delete("devices/{$id}");
    }
}

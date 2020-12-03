<?php

namespace Axsor\PhpIPAM\Http\Requests;

class AddressRequest extends Connector
{
    public function show($address)
    {
        $id = get_id_from_variable($address);

        return $this->get("addresses/{$id}");
    }

    public function ping($address)
    {
        $id = get_id_from_variable($address);

        return $this->get("addresses/{$id}/ping");
    }

    public function byIp(string $ip)
    {
        return $this->get("addresses/search/{$ip}");
    }

    public function byHostname(string $hostname)
    {
        return $this->get("addresses/search_hostname/{$hostname}");
    }

    public function customFields()
    {
        return $this->get('addresses/custom_fields');
    }

    public function tags()
    {
        return $this->get('addresses/tags');
    }

    public function tag($tag)
    {
        $id = get_id_from_variable($tag);

        return $this->get("addresses/tags/{$id}");
    }

    public function tagAddresses($tag)
    {
        $id = get_id_from_variable($tag);

        return $this->get("addresses/tags/{$id}/addresses");
    }

    public function create(array $address)
    {
        return $this->post('addresses', $address);
    }

    public function createFirstFree($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->post("addresses/first_free/{$id}", $subnet);
    }

    public function update($address, array $newData)
    {
        $id = get_id_from_variable($address);

        return $this->patch("addresses/{$id}", standarize_request_body($newData));
    }

    public function drop($address)
    {
        $id = get_id_from_variable($address);

        return $this->delete("addresses/{$id}");
    }
}

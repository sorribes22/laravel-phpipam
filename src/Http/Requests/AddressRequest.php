<?php

namespace Axsor\PhpIPAM\Http\Requests;

class AddressRequest extends Connector
{
    public function show(int $id)
    {
        return $this->get("addresses/{$id}");
    }

    public function ping(int $id)
    {
        return $this->get("addresses/{$id}/ping");
    }

    public function searchIp(string $ip)
    {
        return $this->get("addresses/search/{$ip}");
    }

    public function searchHostname(string $hostname)
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

    public function tag(int $id)
    {
        return $this->get("addresses/tags/{$id}");
    }

    public function tagAddresses(int $id)
    {
        return $this->get("addresses/tags/{$id}/addresses");
    }

    public function create(array $address)
    {
        return $this->post('addresses', $address);
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

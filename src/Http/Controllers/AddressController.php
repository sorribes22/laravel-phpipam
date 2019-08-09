<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Models\Tag;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Http\Requests\AddressRequest;

class AddressController
{
    protected $request;

    public function __construct()
    {
        $this->request = new AddressRequest;
    }

    /**
     * @param int $id
     * @return \Axsor\PhpIPAM\Models\Address
     */
    public function show($id)
    {
        $response = $this->request->show($id);

        return new Address($response['data']);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function ping($id)
    {
        $response = $this->request->ping($id);

        return $response['data']['exit_code'] == 0;
    }

    /**
     * @param string $ip
     * @return \Illuminate\Support\Collection
     */
    public function searchIp(string $ip)
    {
        $response = $this->request->searchIp($ip);

        return response_to_collect($response, Address::class);
    }

    /**
     * The provided hostname must match exactly.
     *
     * @param string $hostname
     * @return \Illuminate\Support\Collection
     */
    public function searchHostname(string $hostname)
    {
        $response = $this->request->searchHostname($hostname);

        return response_to_collect($response, Address::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function customFields()
    {
        $response = $this->request->customFields();

        return response_to_collect($response, CustomField::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function tags()
    {
        $response = $this->request->tags();

        return response_to_collect($response, Tag::class);
    }

    /**
     * @param int $id
     * @return \Axsor\PhpIPAM\Models\Tag
     */
    public function tag(int $id)
    {
        $response = $this->request->tag($id);

        return new Tag($response['data']);
    }

    /**
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function tagAddresses(int $id)
    {
        $response = $this->request->tagAddresses($id);

        return response_to_collect($response, Address::class);
    }

    /**
     * @param array $address
     * @return mixed
     */
    public function create(array $address)
    {
        $response = $this->request->create($address);

        return get_id_or_success_status($response);
    }

    /**
     * @param $address
     * @param array $newData
     * @return mixed
     */
    public function update($address, array $newData)
    {
        $response = $this->request->update($address, $newData);

        return $response['success'];
    }

    /**
     * @param $address
     * @return mixed
     */
    public function drop($address)
    {
        $response = $this->request->drop($address);

        return $response['success'];
    }
}

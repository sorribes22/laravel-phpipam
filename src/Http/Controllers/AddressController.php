<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\AddressRequest;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Tag;

class AddressController
{
    protected $request;

    public function __construct()
    {
        $this->request = new AddressRequest;
    }

    /**
     * @param int $address
     * @return \Axsor\PhpIPAM\Models\Address
     */
    public function show($address)
    {
        $response = $this->request->show($address);

        return new Address($response['data']);
    }

    /**
     * @param int $address
     * @return bool
     */
    public function ping($address)
    {
        $response = $this->request->ping($address);

        return $response['data']['exit_code'] == 0;
    }

    /**
     * @param string $ip
     * @return \Illuminate\Support\Collection
     */
    public function byIp(string $ip)
    {
        $response = $this->request->byIp($ip);

        return response_to_collect($response, Address::class);
    }

    /**
     * The provided hostname must match exactly.
     *
     * @param string $hostname
     * @return \Illuminate\Support\Collection
     */
    public function byHostname(string $hostname)
    {
        $response = $this->request->byHostname($hostname);

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
     * @param int $tag
     * @return \Axsor\PhpIPAM\Models\Tag
     */
    public function tag($tag)
    {
        $response = $this->request->tag($tag);

        return new Tag($response['data']);
    }

    /**
     * @param $tag
     * @return \Illuminate\Support\Collection
     */
    public function tagAddresses($tag)
    {
        $response = $this->request->tagAddresses($tag);

        return response_to_collect($response, Address::class);
    }

    /**
     * @param array $address
     * @return mixed
     */
    public function create(array $address)
    {
        $response = $this->request->create($address);

        return get_key_or_null($response, 'id');
    }

    /**
     * @param array $address
     * @return mixed
     */
    public function createFirstFree($subnet)
    {
        $response = $this->request->createFirstFree($subnet);

        return get_key_or_null($response, 'id');
    }

    /**
     * @param $address
     * @param array $newData
     * @return mixed
     */
    public function update($address, array $newData)
    {
        $response = $this->request->update($address, $newData);

        return (bool) $response['success'];
    }

    /**
     * @param $address
     * @return mixed
     */
    public function drop($address)
    {
        $response = $this->request->drop($address);

        return (bool) $response['success'];
    }
}

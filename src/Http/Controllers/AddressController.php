<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\AddressRequest;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Tag;

class AddressController
{
    protected $request;

    public function __construct(array $config = null)
    {
        $this->request = new AddressRequest($config);
    }

    /**
     * @param int $id
     * @return \Axsor\PhpIPAM\Models\Address
     */
    public function show(int $id)
    {
        $response = $this->request->show($id);

        return new Address($response['data']);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function ping(int $id)
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

        return phpipam_response_to_collect($response, Address::class);
    }

    /**
     * The provided hostname must match exactly
     *
     * @param string $hostname
     * @return \Illuminate\Support\Collection
     */
    public function searchHostname(string $hostname)
    {
        $response = $this->request->searchHostname($hostname);

        return phpipam_response_to_collect($response, Address::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function customFields()
    {
        $response = $this->request->customFields();

        return phpipam_response_to_collect($response, CustomField::class);
    }

    public function tags()
    {
        $response = $this->request->tags();

        return phpipam_response_to_collect($response, Tag::class);
    }

    public function tag(int $id)
    {
        $response = $this->request->tag($id);

        return new Tag($response['data']);
    }

    public function addressesOfTag(int $id)
    {
        $response = $this->request->addressesOfTag($id);

        return phpipam_response_to_collect($response, Address::class);
    }
}

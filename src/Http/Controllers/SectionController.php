<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Models\Section;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Http\Requests\SectionRequest;

class SectionController
{
    protected $request;

    public function __construct()
    {
        $this->request = new SectionRequest;
    }

    public function index()
    {
        $response = $this->request->index();

        return response_to_collect($response, Section::class);
    }

    public function show($section)
    {
        $response = $this->request->show($section);

        return new Section($response['data']);
    }

    public function subnets($section)
    {
        $response = $this->request->subnets($section);

        return response_to_collect($response, Subnet::class);
    }

    public function byName(string $section)
    {
        $response = $this->request->byName($section);

        return new Section($response['data']);
    }

    // TODO upgrade PhpIPAM from 1.3 to 1.5
    //public function customFields()
    //{
    //    $response = $this->request->customFields();
    //
    //    return response_to_collect($response, CustomField::class);
    //}

    public function create(array $section)
    {
        $response = $this->request->create($section);

        return get_key_or_null($response, 'id');
    }

    public function update($section, array $newData)
    {
        $response = $this->request->update($section, $newData);

        return (bool) $response['success'];
    }

    public function drop($section)
    {
        $response = $this->request->drop($section);

        return (bool) $response['success'];
    }
}

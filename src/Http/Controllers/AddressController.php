<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\AddressRequest;

class AddressController
{
    protected $request;

    public function __construct(array $config = null)
    {
        $this->request = new AddressRequest($config);
    }

    public function show(int $id)
    {
        $response = $this->request->show($id);

        return $response->data;
    }
}

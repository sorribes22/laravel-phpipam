<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\CircuitRequest;
use Axsor\PhpIPAM\Models\Circuit;

class CircuitController
{
    protected $request;

    public function __construct()
    {
        $this->request = new CircuitRequest;
    }

    public function index()
    {
        $response = $this->request->index();

        return response_to_collect($response, Circuit::class);
    }

    public function show($circuit)
    {
        $response = $this->request->show($circuit);

        return new Circuit($response['data']);
    }

    public function create(array $circuit)
    {
        $response = $this->request->create($circuit);

        return get_key_or_null($response, 'id');
    }

    public function update($circuit, array $newData)
    {
        $response = $this->request->update($circuit, $newData);

        return (bool) $response['success'];
    }

    public function drop($circuit)
    {
        $response = $this->request->drop($circuit);

        return (bool) $response['success'];
    }
}

<?php

namespace Axsor\PhpIPAM\Http\Requests;

class CircuitRequest extends Connector
{
    public function index()
    {
        return $this->get('circuits');
    }

    public function show($circuit)
    {
        $id = get_id_from_variable($circuit);

        return $this->get("circuits/{$id}");
    }

    public function create(array $circuit)
    {
        return $this->post('circuits', $circuit);
    }

    public function update($circuit, array $newData)
    {
        $id = get_id_from_variable($circuit);

        return $this->patch("circuits/{$id}", $newData);
    }

    public function drop($circuit)
    {
        $id = get_id_from_variable($circuit);

        return $this->delete("circuits/{$id}");
    }
}

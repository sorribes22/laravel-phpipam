<?php

namespace Axsor\PhpIPAM\Http\Requests;

class AddressRequest extends Connector
{
    public function show(int $id)
    {
        return $this->get("addresses/{$id}");
    }
}

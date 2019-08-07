<?php

namespace Axsor\PhpIPAM\Models;

class Model
{
    public function __construct(array $data)
    {
        $this->fill($data);
    }

    public function fill($data)
    {
        $object = json_decode(json_encode($data));

        foreach (array_keys((array) $object) as $key) {
            $this->$key = $object->$key;
        }
    }
}

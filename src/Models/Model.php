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

    public function toArray()
    {
        return (array) $this;
    }

    /**
     * @from laravel5.8
     * @param array $keys
     * @return array
     */
    public function only($keys)
    {
        $results = [];

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $results[$key] = $this->$key;
        }

        return $results;
    }

    public function except($keys)
    {
        $results = [];
        $except = is_array($keys) ? $keys : [$keys];

        foreach (array_keys($this->toArray()) as $key) {
            if (! in_array($key, $except)) {
                $results[$key] = $this->$key;
            }
        }

        return $results;
    }
}

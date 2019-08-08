<?php

if (! function_exists('response_to_collect')) {
    /**
     * Return PhpIPAM response content into a collect of the specified class.
     *
     * @param $response
     * @param $class
     * @return \Illuminate\Support\Collection
     */
    function response_to_collect($response, $class)
    {
        $collection = collect();

        if (array_key_exists('data', $response)) {
            foreach ($response['data'] as $item) {
                $collection->push(new $class($item));
            }
        }

        return $collection;
    }
}

if (! function_exists('get_id_or_success_status')) {
    function get_id_or_success_status($response)
    {
        return $response['success'] ? $response['id'] : $response['success'];
    }
}

if (! function_exists('standardize_booleans')) {
    function standardize_booleans(array $data)
    {
        $result = [];

        foreach (array_keys($data) as $key) {
            switch ($data[$key]) {
                case "\x00":
                case "\0":
                    $result[$key] = 0;
                    break;
                default:
                    $result[$key] = $data[$key];
            }
        }

        return $result;
    }
}

if (! function_exists('unset_null_values')) {
    function unset_null_values(array $data)
    {
        foreach (array_keys($data) as $key) {
            if ($data[$key] === null) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}

if (! function_exists('standarize_request_body')) {
    function standarize_request_body(array $data)
    {
        return standardize_booleans(unset_null_values($data));
    }
}

if (! function_exists('get_id_from_variable')) {
    function get_id_from_variable($data)
    {
        if (is_object($data)) {
            return $data->id;
        } else if (is_array($data)) {
            return $data['id'];
        } else {
            return $data;
        }
    }
}

<?php

if (! function_exists('phpipam_response_to_collect')) {
    /**
     * Return PhpIPAM response content into a collect of the specified class
     *
     * @param $response
     * @param $class
     * @return \Illuminate\Support\Collection
     */
    function phpipam_response_to_collect($response, $class)
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

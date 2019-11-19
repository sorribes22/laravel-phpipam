<?php

namespace Axsor\PhpIPAM\Http\Controllers;

use Axsor\PhpIPAM\Http\Requests\ToolRequest;
use Axsor\PhpIPAM\Models\Location;

class ToolController
{
    protected $request;

    public function __construct()
    {
        $this->request = new ToolRequest();
    }

    public function locations()
    {
        $response = $this->request->locations();

        return response_to_collect($response, Location::class);
    }

    public function location($location)
    {
        $response = $this->request->location($location);

        return new Location($response['data']);
    }

    public function locationCreate(array $location)
    {
        $response = $this->request->locationCreate($location);

        return get_key_or_null($response, 'id');
    }

    public function locationUpdate($location, array $newData)
    {
        $response = $this->request->locationUpdate($location, $newData);

        return (bool) $response['success'];
    }

    public function locationDrop($location)
    {
        $response = $this->request->locationDrop($location);

        return (bool) $response['success'];
    }
}

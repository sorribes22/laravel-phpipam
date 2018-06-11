<?php

namespace Axsor\LaravelPhpIPAM\Models\Locations;


use Illuminate\Support\Collection;

class LocationCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            $this->push(is_array($item) ? new Location($item) : $item);
        }
    }
}
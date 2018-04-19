<?php

namespace Axsor\LaravelPhpIPAM\Models\Subnets;


use Illuminate\Support\Collection;

class SubnetCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);

        foreach ($items as $item)
        {
            $this->push(new Subnet($item));
        }
    }
}
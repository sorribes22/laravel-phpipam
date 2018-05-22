<?php

namespace Axsor\LaravelPhpIPAM\Models\Subnets;


use Illuminate\Support\Collection;

class SubnetCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            // is_array() verify to be available to use ->where() of Collection
            $this->push(is_array($item) ? new Subnet($item) : $item);
        }
    }
}
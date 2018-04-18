<?php

namespace Axsor\LaravelPhpIPAM\Models\IPs;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class IPCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            $this->push(new IP($item));
        }
    }
}
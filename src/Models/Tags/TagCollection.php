<?php

namespace Axsor\LaravelPhpIPAM\Models\Tags;


use Illuminate\Support\Collection;

class TagCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            $this->push(new Tag($item));
        }
    }
}
<?php

namespace Axsor\LaravelPhpIPAM\Models\Sections;


use Illuminate\Support\Collection;

class SectionCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            $this->push(new Section($item));
        }
    }
}
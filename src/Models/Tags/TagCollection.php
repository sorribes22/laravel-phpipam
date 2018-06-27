<?php

namespace Axsor\LaravelPhpIPAM\Models\Tags;


use Illuminate\Database\Eloquent\Collection;

class TagCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct();

        foreach ($items as $item)
        {
            $this->push(is_array($item) ? new Tag($item) : $item);
        }
    }
}
<?php

namespace Axsor\LaravelPhpIPAM\Models\Sections;


use Axsor\LaravelPhpIPAM\Requests\SectionRequest;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function subnets()
    {
        return (new SectionRequest)->subnets($this->id);
    }

    public function customFields()
    {
        return (new SectionRequest)->customFields($this->id);
    }

    protected $guarded = [];
}
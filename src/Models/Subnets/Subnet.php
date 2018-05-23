<?php

namespace Axsor\LaravelPhpIPAM\Models\Subnets;


use Axsor\LaravelPhpIPAM\Requests\SubnetRequest;
use Illuminate\Database\Eloquent\Model;

class Subnet extends Model
{
    public function usage()
    {
        return (new SubnetRequest())->usage($this->id);
    }

    public function firstIPFree()
    {
        return (new SubnetRequest())->firstIPFree($this->id);
    }

    public function slaves()
    {
        return (new SubnetRequest())->slaves($this->id);
    }

    public function addresses()
    {
        return (new SubnetRequest())->addresses($this->id);
    }

    public function address($ip)
    {
        return (new SubnetRequest())->address($this->id, $ip);
    }

    protected $guarded = [];
}
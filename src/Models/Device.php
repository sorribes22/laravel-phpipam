<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Device extends Model
{
    public function drop()
    {
        return PhpIPAM::deviceDrop($this);
    }

    public function update()
    {
        return PhpIPAM::deviceUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function deviceTypes()
    {
        return PhpIPAM::deviceTypes($this);
    }

    public function subnets()
    {
        return PhpIPAM::deviceSubnets($this);
    }

    public function addresses()
    {
        return PhpIPAM::deviceAddresses($this);
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'editDate',
        ];
    }
}

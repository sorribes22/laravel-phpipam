<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Circuit extends Model
{
    public function drop()
    {
        return PhpIPAM::circuitDrop($this);
    }

    public function update()
    {
        return PhpIPAM::circuitUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'editDate',
        ];
    }
}

<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Location extends Model
{
    public function update()
    {
        return PhpIPAM::locationUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function drop()
    {
        return PhpIPAM::locationDrop($this);
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'editDate',
        ];
    }
}

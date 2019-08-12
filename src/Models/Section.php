<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Section extends Model
{
    public function drop()
    {
        return PhpIPAM::sectionDrop($this);
    }

    public function update()
    {
        return PhpIPAM::sectionUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function subnets()
    {
        return PhpIPAM::sectionSubnets($this);
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'editDate',
        ];
    }
}

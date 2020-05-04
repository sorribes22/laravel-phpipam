<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Tag extends Model
{
    public function update()
    {
        return PhpIPAM::tagUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function drop()
    {
        return PhpIPAM::tagDrop($this);
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'editDate',
        ];
    }
}

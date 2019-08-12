<?php

namespace Axsor\PhpIPAM\Models;

use Axsor\PhpIPAM\Facades\PhpIPAM;

class Subnet extends Model
{
    public function update()
    {
        return PhpIPAM::subnetUpdate($this, $this->except($this->getExceptKeys()));
    }

    public function drop()
    {
        return PhpIPAM::subnetDrop($this);
    }

    public function usage()
    {
        return PhpIPAM::subnetUsage($this);
    }

    public function freeAddress()
    {
        return PhpIPAM::subnetFreeAddress($this);
    }

    public function slaves()
    {
        return PhpIPAM::subnetSlaves($this);
    }

    public function slavesRecursive()
    {
        return PhpIPAM::subnetSlavesRecursive($this);
    }

    public function addresses()
    {
        return PhpIPAM::subnetAddresses($this);
    }

    public function ip(string $ip)
    {
        return PhpIPAM::subnetIp($this, $ip);
    }

    public function freeSubnet(int $mask)
    {
        return PhpIPAM::subnetFreeSubnet($this, $mask);
    }

    public function freeSubnets(int $mask)
    {
        return PhpIPAM::subnetFreeSubnets($this, $mask);
    }

    public function resize(int $mask)
    {
        return PhpIPAM::subnetResize($this, $mask);
    }

    public function split($numero)
    {
        return PhpIPAM::subnetSplit($this, $numero);
    }

    public function truncate()
    {
        return PhpIPAM::subnetTruncate($this);
    }

    public function getExceptKeys()
    {
        return [
            'id',
            'ip',
            'editDate',
            'lastSeen',
            'lastScan',
            'lastDiscovery',
            'calculation',
        ];
    }
}

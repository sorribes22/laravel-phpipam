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

    protected $fillable = [
        "id",
        "subnet",
        "mask",
        "sectionId",
        "description",
        "linked_subnet",
        "firewallAddressObject",
        "vrfId",
        "masterSubnetId",
        "allowRequests",
        "vlanId",
        "showName",
        "device",
        "permissions",
        "pingSubnet",
        "discoverSubnet",
        "resolveDNS",
        "DNSrecursive",
        "DNSrecords",
        "nameserverId",
        "scanAgent",
        "isFolder",
        "isFull",
        "tag",
        "threshold",
        "location",
        "editDate",
        "lastScan",
        "lastDiscovery",
        "calculation"
    ];
}
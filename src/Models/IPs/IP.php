<?php

namespace Axsor\LaravelPhpIPAM\Models\IPs;


use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $fillable = [
        "id",
        "subnetId",
        "ip",
        "is_gateway",
        "description",
        "hostname",
        "mac",
        "owner",
        "tag",
        "deviceId",
        "location",
        "port",
        "note",
        "lastSeen",
        "excludePing",
        "PTRignore",
        "PTR",
        "firewallAddressObject",
        "editDate",
    ];
}
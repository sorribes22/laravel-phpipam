<?php

namespace Axsor\LaravelPhpIPAM\Models\Subnets;


use Illuminate\Database\Eloquent\Model;

class SubnetUsage extends Model
{
    protected $fillable = [
        "used",
        "maxhosts",
        "freehosts",
        "freehosts_percent",
        "Offline_percent",
        "Used_percent",
        "Reserved_percent",
        "DHCP_percent",
    ];
}
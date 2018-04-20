<?php

namespace Axsor\LaravelPhpIPAM\Models\IPs;


use Axsor\LaravelPhpIPAM\Requests\IPRequest;
use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    public function ping()
    {
        return (new IPRequest)->ping($this->id);
    }

    public function edit()
    {
        $dataToSend = $this->toArray();

        array_forget($dataToSend, [
            'id', 'ip', 'subnetId', 'deviceId', 'editDate', 'lastSeen', 'is_gateway'
        ]);

        return (new IPRequest)->edit($this->id, $dataToSend);
    }

    public function drop()
    {
        return (new IPRequest)->drop($this->id);
    }

    public function setOwnerAttribute($value)
    {
        $this->attributes['owner'] = (integer) $value;
    }

    public function setTagAttribute($value)
    {
        $this->attributes['tag'] = (integer) $value;
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = (integer) $value;
    }

    public function setPortAttribute($value)
    {
        $this->attributes['port'] = (integer) $value;
    }

    public function setExcludePingAttribute($value)
    {
        $this->attributes['excludePing'] = (boolean) $value;
    }

    public function setPTRIgnoreAttribute($value)
    {
        $this->attributes['PTRignore'] = (boolean) $value;
    }

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
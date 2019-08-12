<?php

namespace Axsor\PhpIPAM\Http\Requests;

class SubnetRequest extends Connector
{
    public function show($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}");
    }

    public function usage($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/usage");
    }

    public function freeAddress($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/first_free");
    }

    public function slaves($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/slaves");
    }

    public function slavesRecursive($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/slaves_recursive");
    }

    public function addresses($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/addresses");
    }

    public function ip($subnet, string $ip)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/addresses/{$ip}");
    }

    public function freeSubnet($subnet, int $mask)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/first_subnet/{$mask}");
    }

    public function freeSubnets($subnet, int $mask)
    {
        $id = get_id_from_variable($subnet);

        return $this->get("subnets/{$id}/all_subnets/{$mask}");
    }

    public function customFields()
    {
        return $this->get('subnets/custom_fields');
    }

    public function byCidr(string $cidr)
    {
        return $this->get("subnets/cidr/{$cidr}");
    }
}

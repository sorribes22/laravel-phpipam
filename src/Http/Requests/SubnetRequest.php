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
        return $this->get("subnets/custom_fields");
    }

    public function byCidr(string $cidr)
    {
        return $this->get("subnets/cidr/{$cidr}");
    }

    public function create(array $data)
    {
        return $this->post("subnets", $data);
    }

    public function createInSubnet($subnet, array $data)
    {
        $id = get_id_from_variable($subnet);

        return $this->post("subnets/{$id}/first_subnet/{$data['mask']}/", $data);
    }

    public function update($subnet, array $newData)
    {
        $id = get_id_from_variable($subnet);

        return $this->patch("subnets/{$id}/", $newData);
    }

    public function resize($subnet, int $mask)
    {
        $id = get_id_from_variable($subnet);

        return $this->patch("subnets/{$id}/resize", ['mask' => $mask]);
    }

    public function split($subnet, int $number)
    {
        $id = get_id_from_variable($subnet);

        return $this->patch("subnets/{$id}/split", ['number' => $number]);
    }

    public function drop($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->delete("subnets/{$id}");
    }

    public function truncate($subnet)
    {
        $id = get_id_from_variable($subnet);

        return $this->delete("subnets/{$id}/truncate");
    }
}

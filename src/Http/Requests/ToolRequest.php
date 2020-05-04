<?php

namespace Axsor\PhpIPAM\Http\Requests;

class ToolRequest extends Connector
{
    public function locations()
    {
        return $this->get('tools/locations');
    }

    public function location($location)
    {
        $id = get_id_from_variable($location);

        return $this->get("tools/locations/{$id}");
    }

    public function locationCreate(array $location)
    {
        return $this->post('tools/locations', $location);
    }

    public function locationUpdate($location, array $newData)
    {
        $id = get_id_from_variable($location);

        return $this->patch("tools/locations/{$id}", $newData);
    }

    public function locationDrop($location)
    {
        $id = get_id_from_variable($location);

        return $this->delete("tools/locations/{$id}");
    }

    public function tags()
    {
        return $this->get('tools/tags');
    }

    public function tag($tag)
    {
        $id = get_id_from_variable($tag);

        return $this->get("tools/tags/{$id}");
    }

    public function tagCreate(array $tag)
    {
        return $this->post('tools/tags', $tag);
    }

    public function tagUpdate($tag, array $newData)
    {
        $id = get_id_from_variable($tag);

        return $this->patch("tools/tags/{$id}", $newData);
    }

    public function tagDrop($tag)
    {
        $id = get_id_from_variable($tag);

        return $this->delete("tools/tags/{$id}");
    }
}

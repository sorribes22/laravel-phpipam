<?php

namespace Axsor\PhpIPAM\Http\Requests;

class SectionRequest extends Connector
{
    public function index()
    {
        return $this->get('sections');
    }

    public function show($section)
    {
        $id = get_id_from_variable($section);

        return $this->get("sections/{$id}");
    }

    public function subnets($section)
    {
        $id = get_id_from_variable($section);

        return $this->get("sections/{$id}/subnets");
    }

    public function byName(string $section)
    {
        return $this->get("sections/{$section}");
    }

    // TODO upgrade PhpIPAM from 1.3 to 1.5
    //public function customFields()
    //{
    //    return $this->get("sections/custom_fields");
    //}

    public function create(array $section)
    {
        return $this->post('sections', $section);
    }

    public function update($section, array $newData)
    {
        $id = get_id_from_variable($section);

        return $this->patch("sections/{$id}", $newData);
    }

    public function drop($section)
    {
        $id = get_id_from_variable($section);

        return $this->delete("sections/{$id}");
    }
}

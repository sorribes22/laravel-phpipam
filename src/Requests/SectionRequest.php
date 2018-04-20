<?php

namespace Axsor\LaravelPhpIPAM\Requests;


use Axsor\LaravelPhpIPAM\Connection;
use Axsor\LaravelPhpIPAM\Models\Sections\Section;
use Axsor\LaravelPhpIPAM\Models\Sections\SectionCollection;
use Axsor\LaravelPhpIPAM\Models\Subnets\SubnetCollection;

class SectionRequest extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all sections
     *
     * @return SectionCollection
     */
    public function sections()
    {
        return new SectionCollection(parent::get("sections/")['data']);
    }

    /**
     * Return section
     *
     * @param $section
     * @return Section
     */
    public function section($section)
    {
        return new Section(parent::get("sections/{$section}/")['data']);
    }

    /**
     * Return all subnets of section
     *
     * @param $section
     * @return SubnetCollection
     */
    public function subnets($section)
    {
        return new SubnetCollection(parent::get("sections/{$section}/subnets/")['data']);
    }

    /**
     * // TODO return into laravel model (How to define custom fields into fillable?)
     *
     * @param $section
     * @return mixed
     */
    public function customFields($section)
    {
        return parent::get("sections/{$section}/custom_fields/")['data'];
    }
}
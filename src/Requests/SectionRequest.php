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
        $response = parent::get("sections/");

        return self::hasContent($response) ? new SectionCollection($response['data']) : new SectionCollection();
    }

    /**
     * Return section
     *
     * @param $section
     * @return Section
     */
    public function section($section)
    {
        $response = parent::get("sections/{$section}/");

        return self::hasContent($response) ? new Section($response['data']) : null;
    }

    /**
     * Return all subnets of section
     *
     * @param $section
     * @return SubnetCollection
     */
    public function subnets($section)
    {
        $response = parent::get("sections/{$section}/subnets/");

        return self::hasContent($response) ? new SubnetCollection($response['data']) : new SubnetCollection();
    }

    /**
     * // TODO return into laravel model (How to define custom fields into fillable?)
     *
     * @param $section
     * @return mixed
     */
    public function customFields($section)
    {
        $response = parent::get("sections/{$section}/custom_fields/");

        return self::hasContent($response) ? $response['data'] : null;
    }

    /**
     * Creates a section
     *
     * @param $section
     * @return mixed
     */
    public function create($section)
    {
        return parent::post('sections/', $section);
    }

    /**
     * Creates and returns a section
     *
     * @param $section
     * @return Section|null
     */
    public function createAndGet($section)
    {
        $response = $this->create($section);

        return array_key_exists('id', $response) ? $this->section($response['id']) : null;
    }
}
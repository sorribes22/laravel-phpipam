<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Section;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class SectionTest extends PhpIPAMTestCase
{
    protected $section;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->section = new Section([
            'id' => 2,
            'hostname' => 'My section',
            'description' => 'Section description',
        ]);
    }

    /** @test */
    public function can_delete_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Section deleted","time":0.036}');

        $result = $this->section->drop();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Section updated","time":0.02}');

        $this->section->name = 'Test';
        $this->section->description = 'Some description';

        $result = $this->section->update();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
}

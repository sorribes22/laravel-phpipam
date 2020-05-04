<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Tag;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class TagTest extends PhpIPAMTestCase
{
    protected $tag;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->tag = new Tag([
            'id' => 2,
            'type' => 'Offline',
        ]);
    }

    /** @test */
    public function can_delete_tag_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"ipTags object deleted","time":0.019}');

        $result = $this->tag->drop();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_tag_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"ipTags object updated","time":0.025}');

        $this->tag->type = 'Online';

        $result = $this->tag->update();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
}

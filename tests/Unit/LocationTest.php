<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Location;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class LocationTest extends PhpIPAMTestCase
{
    protected $location;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->location = new Location([
            'id' => 2,
            'name' => 'Barcelona',
        ]);
    }

    /** @test */
    public function can_delete_location_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"locations object deleted","time":0.019}');

        $result = $this->location->drop();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_location_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"locations object updated","time":0.025}');

        $this->location->name = 'Tarragona';

        $result = $this->location->update();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
}

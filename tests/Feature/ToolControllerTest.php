<?php

namespace Axsor\PhpIPAM\Tests\Feature;

use Axsor\PhpIPAM\Models\Location;
use Axsor\PhpIPAM\Models\Tag;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Facades\PhpIPAM;
use Illuminate\Support\Collection;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class ToolControllerTest extends PhpIPAMTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();
    }

    /** @test */
    public function can_index_locations()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"1","name":"Barcelona","description":null,"address":null,"lat":null,"long":null}],"time":0.014}');

        $locations = PhpIPAM::locations();

        $this->assertTrue(is_object($locations));
        $this->assertEquals($locations->first()->id, 1);
        $this->assertEquals($locations->first()->name, "Barcelona");
        $this->assertEquals($locations->first()->description, null);
        $this->assertEquals($locations->first()->address, null);
        $this->assertEquals($locations->first()->lat, null);
        $this->assertEquals($locations->first()->long, null);
    }

    /** @test */
    public function can_show_locations()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"1","name":"Barcelona","description":null,"address":null,"lat":null,"long":null},"time":0.015}');

        $location = PhpIPAM::location(1);

        $this->assertTrue(is_object($location));
        $this->assertEquals(get_class($location), Location::class);
        $this->assertEquals($location->id, 1);
        $this->assertEquals($location->name, "Barcelona");
        $this->assertEquals($location->description, null);
        $this->assertEquals($location->address, null);
        $this->assertEquals($location->lat, null);
        $this->assertEquals($location->long, null);
    }

    /** @test */
    public function can_create_a_location()
    {
        $this->appendResponse('{"code":201,"success":true,"id":"2","data":"locations object created","time":0.02}');

        $location = PhpIPAM::locationCreate(['name' => 'Girona']);

        $this->assertEquals($location, 2);
    }

    /** @test */
    public function can_update_a_location()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"locations object updated","time":0.025}');

        $result = PhpIPAM::locationUpdate(1, ['name' => 'Tarragona']);

        $this->assertTrue($result);
    }

    /** @test */
    public function can_delete_a_location()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"locations object deleted","time":0.019}');

        $response = PhpIPAM::locationDrop(1);

        $this->assertTrue($response);
    }
}

<?php

namespace Axsor\PhpIPAM\Tests\Feature;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use Axsor\PhpIPAM\Models\Location;
use Axsor\PhpIPAM\Models\Tag;
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
        $this->assertEquals($locations->first()->name, 'Barcelona');
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
        $this->assertEquals($location->name, 'Barcelona');
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

    /** @test */
    public function can_index_tags()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"1","type":"Offline","showtag":"1","bgcolor":"#f59c99","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"},{"id":"2","type":"Used","showtag":"0","bgcolor":"#a9c9a4","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"}],"time":0.014}');

        $tag = PhpIPAM::tags();

        $this->assertTrue(is_object($tag));
        $this->assertEquals($tag->first()->id, 1);
        $this->assertEquals($tag->first()->type, 'Offline');
        $this->assertEquals($tag->first()->showtag, 1);
        $this->assertEquals($tag->first()->bgcolor, '#f59c99');
        $this->assertEquals($tag->first()->fgcolor, '#ffffff');
        $this->assertEquals($tag->first()->compress, 'No');
        $this->assertEquals($tag->first()->locked, 'Yes');
        $this->assertEquals($tag->first()->updateTag, 1);
    }

    /** @test */
    public function can_show_tag()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"1","type":"Offline","showtag":"1","bgcolor":"#f59c99","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"},"time":0.006}');

        $tag = PhpIPAM::tag(1);

        $this->assertTrue(is_object($tag));
        $this->assertEquals(get_class($tag), Tag::class);
        $this->assertEquals($tag->id, 1);
        $this->assertEquals($tag->type, 'Offline');
        $this->assertEquals($tag->showtag, 1);
        $this->assertEquals($tag->bgcolor, '#f59c99');
        $this->assertEquals($tag->fgcolor, '#ffffff');
        $this->assertEquals($tag->compress, 'No');
        $this->assertEquals($tag->locked, 'Yes');
        $this->assertEquals($tag->updateTag, 1);
    }

    /** @test */
    public function can_create_a_tag()
    {
        $this->appendResponse('{"code":201,"success":true,"id":"2","data":"ipTags object created","time":0.013}');

        $tag = PhpIPAM::tagCreate(['type' => 'Tag name']);

        $this->assertEquals($tag, 2);
    }

    /** @test */
    public function can_update_a_tag()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"ipTags object updated","time":0.016}');

        $result = PhpIPAM::tagUpdate(1, ['type' => 'Tag name 2']);

        $this->assertTrue($result);
    }

    /** @test */
    public function can_delete_a_tag()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"ipTags object deleted","time":0.02}');

        $response = PhpIPAM::tagDrop(1);

        $this->assertTrue($response);
    }
}

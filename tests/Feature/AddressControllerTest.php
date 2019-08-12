<?php

namespace Axsor\PhpIPAM\Tests\Feature;

use Axsor\PhpIPAM\Models\Tag;
use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Facades\PhpIPAM;
use Illuminate\Support\Collection;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class AddressControllerTest extends PhpIPAMTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();
    }

    /** @test */
    public function can_get_address_as_object()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"22","subnetId":"2","ip":"10.140.202.211","is_gateway":null,"description":"description of hostname","hostname":"hostname","mac":null,"owner":null,"tag":"18","deviceId":"0","location":"26","port":null,"note":"Large description","lastSeen":null,"excludePing":"0","PTRignore":"0","PTR":"0","firewallAddressObject":null,"editDate":null},"time":0.015}');

        $address = PhpIPAM::address(22);

        $this->assertTrue(is_object($address));
        $this->assertEquals($address->id, 22);
        $this->assertEquals($address->subnetId, 2);
        $this->assertEquals($address->ip, '10.140.202.211');
        $this->assertEquals($address->description, 'description of hostname');
        $this->assertEquals($address->hostname, 'hostname');
        $this->assertEquals($address->tag, 18);
    }

    /** @test */
    public function can_ping_address_and_get_status()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"scan_type":"ping","exit_code":1,"result_code":"OFFLINE","message":"Address offline"},"time":1.022}');

        $result = PhpIPAM::ping(22);

        $this->assertTrue(is_bool($result));
        $this->assertFalse($result);

        $this->appendResponse('{"code":200,"success":true,"data":{"scan_type":"ping","exit_code":0,"result_code":"ONLINE","message":"Address online"},"time":0.022}');

        $result = PhpIPAM::ping(22);
        $this->assertTrue(is_bool($result));
        $this->assertTrue($result);
    }

    /** @test */
    public function can_search_address_by_ip()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"10.140.128.4","is_gateway":null,"description":"The good description","hostname":"hostname","mac":null,"owner":null,"tag":"43","deviceId":null,"location":"1","port":null,"note":"Note","lastSeen":null,"excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":null}],"time":0.021}');

        $result = PhpIPAM::searchIp(22);

        $this->assertEquals(get_class($result), Collection::class);
        $this->assertEquals(get_class($result[0]), Address::class);
        $this->assertEquals(22, $result[0]->id);
        $this->assertEquals(2, $result[0]->subnetId);
        $this->assertEquals('10.140.128.4', $result[0]->ip);
        $this->assertEquals('The good description', $result[0]->description);
        $this->assertEquals('hostname', $result[0]->hostname);
        $this->assertEquals(43, $result[0]->tag);
    }

    /** @test */
    public function can_search_address_by_hostname()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"10.140.128.4","is_gateway":null,"description":"The good description","hostname":"hostname","mac":null,"owner":null,"tag":"43","deviceId":null,"location":"1","port":null,"note":"Note","lastSeen":null,"excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":null}],"time":0.021}');

        $result = PhpIPAM::searchHostname('hostname');

        $this->assertEquals(get_class($result), Collection::class);
        $this->assertEquals(get_class($result[0]), Address::class);
        $this->assertEquals(22, $result[0]->id);
        $this->assertEquals(2, $result[0]->subnetId);
        $this->assertEquals('10.140.128.4', $result[0]->ip);
        $this->assertEquals('The good description', $result[0]->description);
        $this->assertEquals('hostname', $result[0]->hostname);
        $this->assertEquals(43, $result[0]->tag);
    }

    /** @test */
    public function can_get_custom_fields_from_addresses()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"custom_X":{"name":"custom_X","type":"varchar(40)","Comment":"","Null":"YES","Default":null},"custom_Y":{"name":"custom_Y","type":"varchar(40)","Comment":"","Null":"YES","Default":null}},"time":0.018}');

        $result = PhpIPAM::customFields();

        $this->assertEquals(get_class($result), Collection::class);
        $this->assertEquals(get_class($result[0]), CustomField::class);
        $this->assertEquals('custom_X', $result[0]->name);
        $this->assertEquals('varchar(40)', $result[0]->type);
        $this->assertEquals('custom_Y', $result[1]->name);
        $this->assertEquals('varchar(40)', $result[1]->type);
    }

    /** @test */
    public function can_get_tags()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"1","type":"Offline","showtag":"1","bgcolor":"#f59c99","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"},{"id":"2","type":"Used","showtag":"0","bgcolor":"#a9c9a4","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"}],"time":0.005}');

        $result = PhpIPAM::tags();

        $this->assertEquals(get_class($result), Collection::class);
        $this->assertEquals(get_class($result[0]), Tag::class);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals('Offline', $result[0]->type);
        $this->assertEquals(2, $result[1]->id);
        $this->assertEquals('Used', $result[1]->type);
    }

    /** @test */
    public function can_get_tag()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"1","type":"Offline","showtag":"1","bgcolor":"#f59c99","fgcolor":"#ffffff","compress":"No","locked":"Yes","updateTag":"1"},"time":0.005}');

        $tag = PhpIPAM::tag(1);

        $this->assertEquals(get_class($tag), Tag::class);
        $this->assertEquals(1, $tag->id);
        $this->assertEquals('Offline', $tag->type);
        $this->assertEquals('1', $tag->showtag);
        $this->assertEquals('#f59c99', $tag->bgcolor);
        $this->assertEquals('#ffffff', $tag->fgcolor);
    }

    /** @test */
    public function can_get_tag_addresses()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"10.12.1.246","is_gateway":null,"description":"The good description","hostname":"hostname","mac":null,"owner":null,"tag":"2","deviceId":null,"location":"4","port":null,"note":"note","lastSeen":null,"excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":null}],"time":0.051}');

        $addresses = PhpIPAM::tagAddresses(2);

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(get_class($addresses[0]), Address::class);
        $this->assertEquals(22, $addresses[0]->id);
        $this->assertEquals(2, $addresses[0]->subnetId);
        $this->assertEquals('10.12.1.246', $addresses[0]->ip);
        $this->assertEquals('The good description', $addresses[0]->description);
        $this->assertEquals('hostname', $addresses[0]->hostname);
        $this->assertEquals(2, $addresses[0]->tag);
    }

    /** @test */
    public function can_create_address()
    {
        $this->appendResponse('{"code":201,"success":true,"message":"Address created","id":"22","time":0.034}');
        $data = [
            'ip' => '10.140.128.1',
            'hostname' => 'Router',
            'description' => 'Some description',
            'subnetId' => 2,
        ];

        $id = PhpIPAM::addressCreate($data);
        $this->assertEquals(22, $id);
    }

    /** @test */
    public function can_update_address()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Address updated","time":0.02}');

        $data = [
            'hostname' => 'Router',
            'description' => 'Some description',
        ];

        $status = PhpIPAM::addressUpdate(22, $data);
        $this->assertIsBool($status);
        $this->assertTrue($status);
    }

    /** @test */
    public function can_delete_address()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Address deleted","time":0.036}');

        $status = PhpIPAM::addressDrop(22);
        $this->assertIsBool($status);
        $this->assertTrue($status);
    }
}

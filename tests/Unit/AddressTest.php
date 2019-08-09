<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class AddressTest extends PhpIPAMTestCase
{
    protected $address;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->address = new Address([
            'id' => 22,
            'hostname' => 'Router',
            'description' => 'My address',
        ]);
    }

    /** @test */
    public function can_delete_address_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Address deleted","time":0.036}');

        $result = $this->address->drop();

        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_address_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Address updated","time":0.02}');

        $this->address->hostname = 'Router';
        $this->address->description = 'Some description';

        $result = $this->address->update();

        $this->assertTrue($result);
    }

    /** @test */
    public function can_ping_address_from_model()
    {
        // Success
        $this->appendResponse('{"code":200,"success":true,"data":{"scan_type":"ping","exit_code":0,"result_code":"ONLINE","message":"Address online"},"time":0.022}');

        $result = $this->address->ping();

        $this->assertTrue($result);

        // Failed
        $this->appendResponse('{"code":200,"success":true,"data":{"scan_type":"ping","exit_code":1,"result_code":"OFFLINE","message":"Address offline"},"time":1.022}');

        $result = $this->address->ping();

        $this->assertFalse($result);
    }
}

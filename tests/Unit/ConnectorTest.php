<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use GuzzleHttp\Psr7\Response;

class ConnectorTest extends PhpIPAMTestCase
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
    public function cache_forgets_if_gets_401_response()
    {
        $this->mock->append(new Response(401, [], '{"code":401,"success":false,"message":"Unauthorized","time":0.004}'));
        $this->appendLoginResponse();
        $this->appendResponse('{"code":200,"success":true,"message":"Address deleted","time":0.036}');

        $result = $this->address->drop();

        $this->assertTrue($result);
        $this->assertEquals(0, $this->mock->count());
    }
}

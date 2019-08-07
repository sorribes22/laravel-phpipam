<?php

namespace Axsor\PhpIPAM\Tests;

use Axsor\PhpIPAM\PhpIPAM;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PhpIPAMTest extends TestCase
{
    /** @test */
    public function it_returns_a_address()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"code":200,"success":true,"data":{"id":"111","subnetId":"2","ip":"10.9.0.27","is_gateway":null,"description":"Address description","hostname":"hostname","mac":"","owner":"0","tag":"18","deviceId":null,"location":"1","port":"0","note":"Some address note","lastSeen":null,"excludePing":"1","PTRignore":"1","PTR":"0","firewallAddressObject":null,"editDate":"2019-06-25 10:46:25",dns_name":null,"links":[{"rel":"self","href":"\/api\/app\/addresses\/111\/","methods":["GET","POST","DELETE","PATCH"]},{"rel":"ping","href":"\/api\/app\/addresses\/111\/ping\/","methods":["GET"]}]},"time":0.006}'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $phpipam = new PhpIPAM($client);

        $ip = $phpipam->address(111);

        $this->assertEquals([
            "id" => "111",
            "subnetId"=> "2",
            "ip"=> "10.9.0.27",
            "is_gateway" => null,
            "description" => "Address description",
            "hostname" => "hostname",
            "mac" => "",
            "owner" => "0",
            "tag" => "18",
            "deviceId" => null,
            "location" => "1",
            "port" => "0",
            "note" => "Some address note",
            "lastSeen" => null,
            "excludePing" => "1",
            "PTRignore" => "1",
            "PTR" => "0",
            "firewallAddressObject" => null,
            "editDate" => "2019-06-25 10:46:25",
            "dns_name" => null
        ], $ip);

        $this->assertTrue(true);
    }
}

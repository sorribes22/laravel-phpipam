<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Data;
use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class SubnetTest extends PhpIPAMTestCase
{
    protected $subnet;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->subnet = new Subnet([
            'id' => 2,
            'subnet' => '192.168.1.0',
            'mask' => '24',
            'description' => 'Subnet description',
        ]);
    }

    /** @test */
    public function can_delete_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Section deleted","time":0.036}');

        $result = $this->subnet->drop();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet updated","time":0.018}');

        $this->subnet->name = 'Test';
        $this->subnet->description = 'Some description';

        $result = $this->subnet->update();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_get_usage_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"used":"28","maxhosts":"30","freehosts":"2","freehosts_percent":6.67,"Offline_percent":0,"Used_percent":3.33},"time":0.018}');

        $usage = $this->subnet->usage();

        $this->assertIsObject($usage);
        $this->assertEquals(get_class($usage), Data::class);
        $this->assertEquals(28, $usage->used);
        $this->assertEquals(30, $usage->maxhosts);
        $this->assertEquals(2, $usage->freehosts);
        $this->assertEquals(6.67, $usage->freehosts_percent);
    }

    /** @test */
    public function can_get_first_free_ip_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":"192.168.1.2","time":0.024}');
        $ip = $this->subnet->freeAddress();

        $this->assertIsString($ip);
        $this->assertEquals('192.168.1.2', $ip);

        $this->appendResponse('{"code":200,"success":0,"message":"No free addresses found","time":0.009}');
        $ip = $this->subnet->freeAddress();

        $this->assertIsNotString($ip);
        $this->assertEquals(null, $ip);
    }

    /** @test */
    public function can_get_subnet_slaves_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"11","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"2","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":null,"lastScan":null,"lastDiscovery":null}],"time":0.018}');

        $slaves = $this->subnet->slaves();

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals('192.168.1.0', $slaves[0]->subnet);
        $this->assertEquals('24', $slaves[0]->mask);
        $this->assertEquals('LAN', $slaves[0]->description);

        $this->appendResponse('{"code":200,"success":0,"message":"No slaves","time":0.017}');

        $slaves = $this->subnet->slaves();

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals(0, $slaves->count());
    }

    /** @test */
    public function can_get_subnet_slaves_recursive_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"11","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"2","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":null,"lastScan":null,"lastDiscovery":null}],"time":0.018}');

        $slaves = $this->subnet->slavesRecursive();

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals(1, $slaves->count());
        $this->assertEquals('192.168.1.0', $slaves[0]->subnet);
        $this->assertEquals('24', $slaves[0]->mask);
        $this->assertEquals('LAN', $slaves[0]->description);
    }

    /** @test */
    public function can_get_addresses_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"192.168.1.4","is_gateway":null,"description":"Description","hostname":"Hostname","mac":null,"owner":null,"tag":"39","deviceId":null,"location":null,"port":null,"note":"Note","lastSeen":"2019-07-18 18:34:49","excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":"2019-07-18 18:34:49"}],"time":0.016}');

        $addresses = $this->subnet->addresses();

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(1, $addresses->count());
        $this->assertEquals('192.168.1.4', $addresses[0]->ip);
        $this->assertEquals('Hostname', $addresses[0]->hostname);
        $this->assertEquals('Description', $addresses[0]->description);
    }

    /** @test */
    public function can_get_address_by_ip_from_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"192.168.1.4","is_gateway":null,"description":"Description","hostname":"Hostname","mac":null,"owner":null,"tag":"39","deviceId":null,"location":null,"port":null,"note":"Note","lastSeen":"2019-07-18 18:34:49","excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":"2019-07-18 18:34:49"}],"time":0.016}');

        $addresses = $this->subnet->ip('192.168.1.4');

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(1, $addresses->count());
        $this->assertEquals('192.168.1.4', $addresses[0]->ip);
        $this->assertEquals('Hostname', $addresses[0]->hostname);
        $this->assertEquals('Description', $addresses[0]->description);

        $this->appendResponse('{"code":200,"success":0,"message":"No addresses found","time":0.008}');

        $addresses = $this->subnet->ip('192.168.1.4');

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(0, $addresses->count());
    }

    /** @test */
    public function can_get_first_free_subnet_by_mask()
    {
        $this->appendResponse('{"code":200,"success":true,"data":"192.168.1.0\/27","time":0.008}');

        $response = $this->subnet->freeSubnet(27);

        $this->assertIsString($response);
        $this->assertEquals($response, '192.168.1.0/27');

        $this->appendResponse('{"code":200,"success":0,"message":"No subnets found","time":0.01}');

        $response = $this->subnet->freeSubnet(16);

        $this->assertIsNotString($response);
        $this->assertEquals($response, null);
    }

    /** @test */
    public function can_get_all_free_subnets_by_mask()
    {
        $this->appendResponse('{"code":200,"success":true,"data":["192.168.1.0\/27","192.168.1.32\/27","192.168.1.64\/27","192.168.1.96\/27","192.168.1.128\/27","192.168.1.160\/27","192.168.1.192\/27","192.168.1.224\/27"],"time":0.007}');

        $response = $this->subnet->freeSubnets(27);

        $this->assertIsNotString($response);
        $this->assertIsObject($response);
        $this->assertEquals(get_class($response), Collection::class);
        $this->assertEquals($response->count(), 8);
        $this->assertTrue(in_array('192.168.1.0/27', $response->toArray()));
    }

    /** @test */
    public function can_resize_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet resized","time":0.028}');

        $response = $this->subnet->resize(25);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_split_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet splitted","time":0.056}');

        $response = $this->subnet->split(4);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_truncate_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet truncated","time":0.018}');

        $response = $this->subnet->truncate();

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }
}

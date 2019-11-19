<?php

namespace Axsor\PhpIPAM\Tests\Feature;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Data;
use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class SubnetControllerTest extends PhpIPAMTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();
    }

    /** @test */
    public function can_get_subnet_as_object()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"2","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":null,"masterSubnetId":"0","allowRequests":"0","vlanId":"0","showName":"1","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"14","editDate":"2018-08-06 15:33:47","lastScan":null,"lastDiscovery":null,"calculation":{"Type":"IPv4","IP address":"\/","Network":"192.168.1.0","Broadcast":"192.168.1.255","Subnet bitmask":"24","Subnet netmask":"255.255.255.0","Subnet wildcard":"0.0.0.255","Min host IP":"10.0.18.97","Max host IP":"192.168.1.254","Number of hosts":"254","Subnet Class":"private A"}},"time":0.016}');

        $subnet = PhpIPAM::subnet(2);

        $this->assertIsObject($subnet);
        $this->assertEquals(get_class($subnet), Subnet::class);
        $this->assertEquals(2, $subnet->id);
        $this->assertEquals('LAN', $subnet->description);
        $this->assertEquals('192.168.1.0', $subnet->subnet);
        $this->assertEquals('192.168.1.0', $subnet->calculation->Network);
        $this->assertEquals('192.168.1.0', $subnet->calculation->Network);
        $this->assertEquals('0.0.0.255', $subnet->calculation->{'Subnet wildcard'});
    }

    /** @test */
    public function can_get_subnet_usage_as_Data_object()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"used":"28","maxhosts":"30","freehosts":"2","freehosts_percent":6.67,"Offline_percent":0,"Used_percent":3.33},"time":0.018}');

        $usage = PhpIPAM::subnetUsage(2);

        $this->assertIsObject($usage);
        $this->assertEquals(get_class($usage), Data::class);
        $this->assertEquals(28, $usage->used);
        $this->assertEquals(30, $usage->maxhosts);
        $this->assertEquals(2, $usage->freehosts);
        $this->assertEquals(6.67, $usage->freehosts_percent);
    }

    /** @test */
    public function can_get_first_free_ip_address()
    {
        $this->appendResponse('{"code":200,"success":true,"data":"192.168.1.2","time":0.024}');

        $ip = PhpIPAM::subnetFreeAddress(2);

        $this->assertIsString($ip);
        $this->assertEquals('192.168.1.2', $ip);
    }

    /** @test */
    public function can_get_null_if_no_first_free_ip_address_exists()
    {
        $this->appendResponse('{"code":200,"success":0,"message":"No free addresses found","time":0.009}');

        $ip = PhpIPAM::subnetFreeAddress(2);

        $this->assertIsNotString($ip);
        $this->assertEquals(null, $ip);
    }

    /** @test */
    public function can_get_slaves_subnets()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"11","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"2","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":null,"lastScan":null,"lastDiscovery":null}],"time":0.018}');

        $slaves = PhpIPAM::subnetSlaves(2);

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals('192.168.1.0', $slaves[0]->subnet);
        $this->assertEquals('24', $slaves[0]->mask);
        $this->assertEquals('LAN', $slaves[0]->description);
    }

    /** @test */
    public function can_get_empty_collection_if_subnet_does_not_have_slaves_subnets()
    {
        $this->appendResponse('{"code":200,"success":0,"message":"No slaves","time":0.017}');

        $slaves = PhpIPAM::subnetSlaves(2);

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals(0, $slaves->count());
    }

    /** @test */
    public function can_get_subnets_recursive()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"11","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"2","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":null,"lastScan":null,"lastDiscovery":null}],"time":0.018}');

        $slaves = PhpIPAM::subnetSlaves(2);

        $this->assertEquals(get_class($slaves), Collection::class);
        $this->assertEquals(1, $slaves->count());
        $this->assertEquals('192.168.1.0', $slaves[0]->subnet);
        $this->assertEquals('24', $slaves[0]->mask);
        $this->assertEquals('LAN', $slaves[0]->description);
    }

    /** @test */
    public function can_get_addresses_from_subnet_as_collection()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnetId":"2","ip":"192.168.1.4","is_gateway":null,"description":"Description","hostname":"Hostname","mac":null,"owner":null,"tag":"39","deviceId":null,"location":null,"port":null,"note":"Note","lastSeen":"2019-07-18 18:34:49","excludePing":null,"PTRignore":null,"PTR":"0","firewallAddressObject":null,"editDate":"2019-07-18 18:34:49"}],"time":0.016}');

        $addresses = PhpIPAM::subnetAddresses(2);

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

        $addresses = PhpIPAM::subnetIp(2, '192.168.1.4');

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(1, $addresses->count());
        $this->assertEquals('192.168.1.4', $addresses[0]->ip);
        $this->assertEquals('Hostname', $addresses[0]->hostname);
        $this->assertEquals('Description', $addresses[0]->description);
    }

    /** @test */
    public function can_get_empty_address_collection_searching_by_ip()
    {
        $this->appendResponse('{"code":200,"success":0,"message":"No addresses found","time":0.008}');

        $addresses = PhpIPAM::subnetIp(2, '192.168.1.4');

        $this->assertEquals(get_class($addresses), Collection::class);
        $this->assertEquals(0, $addresses->count());
    }

    /** @test */
    public function can_get_first_free_subnet_by_mask()
    {
        $this->appendResponse('{"code":200,"success":true,"data":"192.168.1.0\/27","time":0.008}');

        $response = PhpIPAM::subnetFreeSubnet(2, 27);

        $this->assertIsString($response);
        $this->assertEquals($response, '192.168.1.0/27');
    }

    /** @test */
    public function can_get_null_if_not_first_free_subnet_by_mask_exists()
    {
        $this->appendResponse('{"code":200,"success":0,"message":"No subnets found","time":0.01}');

        $response = PhpIPAM::subnetFreeSubnet(2, 27);

        $this->assertIsNotString($response);
        $this->assertEquals($response, null);
    }

    /** @test */
    public function can_get_all_free_subnets_by_mask()
    {
        $this->appendResponse('{"code":200,"success":true,"data":["192.168.1.0\/27","192.168.1.32\/27","192.168.1.64\/27","192.168.1.96\/27","192.168.1.128\/27","192.168.1.160\/27","192.168.1.192\/27","192.168.1.224\/27"],"time":0.007}');

        $response = PhpIPAM::subnetFreeSubnets(2, 27);

        $this->assertIsNotString($response);
        $this->assertIsObject($response);
        $this->assertEquals(get_class($response), Collection::class);
        $this->assertEquals($response->count(), 8);
        $this->assertTrue(in_array('192.168.1.0/27', $response->toArray()));
    }

    /** @test */
    public function can_get_subnet_custom_fields()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"custom_CUSTOM_FIELD":{"name":"custom_CUSTOM_FIELD","type":"varchar(40)","Comment":"","Null":"YES","Default":null}},"time":0.014}');

        $response = PhpIPAM::subnetCustomFields();

        $this->assertIsObject($response);
        $this->assertEquals(get_class($response), Collection::class);
        $this->assertEquals($response->count(), 1);
        $this->assertEquals(get_class($response->first()), CustomField::class);
        $this->assertEquals($response->first()->name, 'custom_CUSTOM_FIELD');
    }

    /** @test */
    public function can_get_empty_collection_of_subnet_custom_fields()
    {
        $this->appendResponse('{"code":200,"success":0,"message":"No custom fields defined","time":0.02}');

        $response = PhpIPAM::subnetCustomFields();

        $this->assertIsObject($response);
        $this->assertEquals(get_class($response), Collection::class);
        $this->assertEquals($response->count(), 0);
    }

    /** @test */
    public function can_get_subnet_searching_by_cidr()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnet":"192.168.1.0","mask":"24","sectionId":"15","description":"Prova developement","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"0","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"3\":\"2\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"1","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"14","editDate":null,"lastScan":null,"lastDiscovery":null}],"time":0.008}');

        $response = PhpIPAM::subnetByCidr('192.168.1.0/24');

        $this->assertIsObject($response);
        $this->assertEquals(get_class($response), Collection::class);
        $this->assertEquals($response->count(), 1);
        $this->assertEquals(get_class($response->first()), Subnet::class);
        $this->assertEquals($response->first()->subnet, '192.168.1.0');
        $this->assertEquals($response->first()->mask, '24');
    }

    /** @test */
    public function can_create_subnet()
    {
        $this->appendResponse('{"code":201,"success":true,"message":"Subnet created","id":"22","data":"192.168.3.0\/24","time":0.035}');

        $response = PhpIPAM::subnetCreate([[
            'subnet' => '192.168.3.0',
            'sectionId' => 15,
            'mask' => 24,
        ]]);

        $this->assertEquals($response, 22);
    }

    /** @test */
    public function can_create_subnet_in_subnet()
    {
        $this->appendResponse('{"code":201,"success":true,"message":"Subnet created","id":"23","data":"192.168.1.128\/25","time":0.036}');

        $response = PhpIPAM::subnetCreateInSubnet(22, [
            'mask' => 25,
        ]);

        $this->assertEquals($response, 23);
    }

    /** @test */
    public function can_update_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet updated","time":0.018}');

        $response = PhpIPAM::subnetUpdate(22, [
            'description' => 'Test description',
        ]);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_resize_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet resized","time":0.028}');

        $response = PhpIPAM::subnetResize(22, 25);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_split_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet splitted","time":0.056}');

        $response = PhpIPAM::subnetSplit(22, 4);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_delete_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet deleted","time":0.039}');

        $response = PhpIPAM::subnetDrop(22);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }

    /** @test */
    public function can_truncate_a_subnet()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Subnet truncated","time":0.018}');

        $response = PhpIPAM::subnetTruncate(22);

        $this->assertIsBool($response);
        $this->assertEquals($response, true);
    }
}

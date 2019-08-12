<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Section;
use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class SectionTest extends PhpIPAMTestCase
{
    protected $section;

    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();

        $this->section = new Section([
            'id' => 2,
            'hostname' => 'My section',
            'description' => 'Section description',
        ]);
    }

    /** @test */
    public function can_delete_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Section deleted","time":0.036}');

        $result = $this->section->drop();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_edit_section_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"message":"Section updated","time":0.02}');

        $this->section->name = 'Test';
        $this->section->description = 'Some description';

        $result = $this->section->update();

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /** @test */
    public function can_get_subnets_from_model()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"0","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"2\":\"3\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":"2019-06-20 19:03:24","lastScan":null,"lastDiscovery":null,"usage":{"used":"0","maxhosts":"253","freehosts":"252","freehosts_percent":99,"Offline_percent":0,"Used_percent":0}}],"time":0.119}');

        $subnets = $this->section->subnets();

        $this->assertEquals(get_class($subnets), Collection::class);
        $this->assertEquals(get_class($subnets[0]), Subnet::class);
        $this->assertEquals(22, $subnets[0]->id);
        $this->assertEquals('192.168.1.0', $subnets[0]->subnet);
        $this->assertEquals('24', $subnets[0]->mask);
    }
}

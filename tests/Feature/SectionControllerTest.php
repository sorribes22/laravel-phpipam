<?php

namespace Axsor\PhpIPAM\Tests\Feature;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use Axsor\PhpIPAM\Models\CustomField;
use Axsor\PhpIPAM\Models\Section;
use Axsor\PhpIPAM\Models\Subnet;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class SectionControllerTest extends PhpIPAMTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->startMocker();
    }

    /** @test */
    public function can_index_sections_as_collection()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"1","name":"My section","description":"Section","masterSection":"0","permissions":"{\"2\":\"3\"}","strictMode":"1","subnetOrdering":"default","order":null,"editDate":null,"showVLAN":"1","showVRF":"1","showSupernetOnly":"1","DNS":null}],"time":0.013}');

        $sections = PhpIPAM::sections();

        $this->assertEquals(get_class($sections), Collection::class);
        $this->assertEquals(get_class($sections[0]), Section::class);
        $this->assertEquals(1, $sections[0]->id);
        $this->assertEquals("My section", $sections[0]->name);
        $this->assertEquals('Section', $sections[0]->description);
    }

    /** @test */
    public function can_get_section_as_object()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"1","name":"My section","description":"Section","masterSection":"0","permissions":"{\"2\":\"3\"}","strictMode":"1","subnetOrdering":"default","order":null,"editDate":null,"showVLAN":"1","showVRF":"1","showSupernetOnly":"1","DNS":null},"time":0.013}');

        $section = PhpIPAM::section(1);

        $this->assertEquals(get_class($section), Section::class);
        $this->assertEquals(1, $section->id);
        $this->assertEquals("My section", $section->name);
        $this->assertEquals('Section', $section->description);
    }

    /** @test */
    public function can_get_subnets_of_section_as_collection()
    {
        $this->appendResponse('{"code":200,"success":true,"data":[{"id":"22","subnet":"192.168.1.0","mask":"24","sectionId":"1","description":"LAN","linked_subnet":null,"firewallAddressObject":null,"vrfId":"0","masterSubnetId":"0","allowRequests":"0","vlanId":"0","showName":"0","device":"0","permissions":"{\"2\":\"3\"}","pingSubnet":"0","discoverSubnet":"0","resolveDNS":"0","DNSrecursive":"0","DNSrecords":"0","nameserverId":"0","scanAgent":"0","isFolder":"0","isFull":"0","tag":"2","threshold":"0","location":"0","editDate":"2019-06-20 19:03:24","lastScan":null,"lastDiscovery":null,"usage":{"used":"0","maxhosts":"253","freehosts":"252","freehosts_percent":99,"Offline_percent":0,"Used_percent":0}}],"time":0.119}');

        $subnets = PhpIPAM::sectionSubnets(1);

        $this->assertEquals(get_class($subnets), Collection::class);
        $this->assertEquals(get_class($subnets[0]), Subnet::class);
        $this->assertEquals(22, $subnets[0]->id);
        $this->assertEquals('192.168.1.0', $subnets[0]->subnet);
        $this->assertEquals('24', $subnets[0]->mask);
    }

    /** @test */
    public function can_get_section_by_name()
    {
        $this->appendResponse('{"code":200,"success":true,"data":{"id":"1","name":"My section","description":"My awesome section","masterSection":"0","permissions":"{\"3\":\"2\"}","strictMode":"1","subnetOrdering":"default","order":"1","editDate":"2018-08-06 15:33:47","showVLAN":"0","showVRF":"0","showSupernetOnly":"0","DNS":null},"time":0.007}');

        $section = PhpIPAM::sectionByName("My section");

        $this->assertEquals(get_class($section), Section::class);
        $this->assertEquals(1, $section->id);
        $this->assertEquals('My section', $section->name);
        $this->assertEquals('My awesome section', $section->description);
    }

    // TODO upgrade PhpIPAM from 1.3 to 1.5
    ///** @test */
    //public function can_get_custom_fields()
    //{
    //    $this->appendResponse('{"code":200,"success":true,"data":{"custom_X":{"name":"custom_X","type":"varchar(40)","Comment":"","Null":"YES","Default":null},"custom_Y":{"name":"custom_Y","type":"varchar(40)","Comment":"","Null":"YES","Default":null}},"time":0.018}');
    //
    //    $result = PhpIPAM::sectionCustomFields();
    //
    //    $this->assertEquals(get_class($result), Collection::class);
    //    $this->assertEquals(get_class($result[0]), CustomField::class);
    //    $this->assertEquals('custom_X', $result[0]->name);
    //    $this->assertEquals('varchar(40)', $result[0]->type);
    //    $this->assertEquals('custom_Y', $result[1]->name);
    //    $this->assertEquals('varchar(40)', $result[1]->type);
    //}

    /** @test */
    public function can_create_section()
    {
        $this->appendResponse('{"code":201,"success":true,"message":"Section created","id":"2","time":0.037}');

        $result = PhpIPAM::sectionCreate(['name' => 'My section', 'description' => 'LAN Subnets']);

        $this->assertEquals(2, $result);
    }

    /** @test */
    public function can_update_section()
    {
        $this->appendResponse('{"code":200,"success":true,"time":0.026}');

        $result = PhpIPAM::sectionUpdate(1, ['description' => 'hey!']);

        $this->assertIsBool($result);
        $this->assertTrue(true);
    }

    /** @test */
    public function can_delete_section()
    {
        $this->appendResponse('{"code":200,"success":true,"time":0.02}');

        $result = PhpIPAM::sectionDrop(1);

        $this->assertIsBool($result);
        $this->assertTrue(true);
    }
}

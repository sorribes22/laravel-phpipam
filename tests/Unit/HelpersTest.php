<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;
use Illuminate\Support\Collection;

class HelpersTest extends PhpIPAMTestCase
{
    /** @test */
    public function get_key_when_success_its_ok()
    {
        $response = [
            'code' => 201,
            'success' => true,
            'message' => 'Address created',
            'id' => '40481',
            'time' => 0.037,
        ];

        $this->assertEquals(40481, get_key_or_null($response, 'id'));
    }

    /** @test */
    public function get_null_when_success_its_not_ok()
    {
        $response = [
            'code' => 500,
            'success' => false,
            'message' => 'IP address not in selected subnet! (10.0.18.129)',
            'time' => 0.037,
        ];

        $this->assertEquals(null, get_key_or_null($response, 'id'));
    }

    /** @test */
    public function standardize_booleans_from_array()
    {
        $data = [
            'id' => '40482',
            'mac' => 'ff:ff:ff:ff:ff:ff',
            'owner' => '',
            'tag' => '39',
            'location' => null,
            'port' => '',
            'excludePing' => "\x00",
            'PTRignore' => "\0",
            'PTR' => '0',
            'firewallAddressObject' => null,
            'custom_USUARIS' => '2',
        ];

        $changed = standardize_booleans($data);

        $this->assertTrue($changed['excludePing'] === 0);
        $this->assertTrue($changed['PTRignore'] === 0);
    }

    /** @test */
    public function unset_null_values_return_correct_values()
    {
        $data = [
            'id' => '40482',
            'mac' => 'ff:ff:ff:ff:ff:ff',
            'owner' => '',
            'tag' => '39',
            'location' => null,
            'port' => '',
            'excludePing' => "\x00",
            'PTRignore' => "\0",
            'PTR' => '0',
            'firewallAddressObject' => null,
        ];

        $result = unset_null_values($data);

        $this->assertEquals($result, [
            'id' => '40482',
            'mac' => 'ff:ff:ff:ff:ff:ff',
            'owner' => '',
            'tag' => '39',
            'port' => '',
            'excludePing' => "\x00",
            'PTRignore' => "\0",
            'PTR' => '0',
        ]);
    }

    /** @test */
    public function standarize_request_body_return_correct_values()
    {
        $data = [
            'id' => '40482',
            'mac' => 'ff:ff:ff:ff:ff:ff',
            'owner' => '',
            'tag' => '39',
            'location' => null,
            'port' => '',
            'excludePing' => "\x00",
            'PTRignore' => "\0",
            'PTR' => '0',
            'firewallAddressObject' => null,
        ];

        $result = standarize_request_body($data);

        $this->assertEquals($result, [
            'id' => '40482',
            'mac' => 'ff:ff:ff:ff:ff:ff',
            'owner' => '',
            'tag' => '39',
            'port' => '',
            'excludePing' => 0,
            'PTRignore' => 0,
            'PTR' => '0',
        ]);
    }

    /** @test */
    public function can_get_id_from_id()
    {
        $id = 22;

        $result = get_id_from_variable($id);
        $this->assertEquals($result, 22);
    }

    /** @test */
    public function can_get_id_from_object()
    {
        $object = new Address(['id' => 22]);

        $result = get_id_from_variable($object);
        $this->assertEquals($result, 22);
    }

    /** @test */
    public function can_get_id_from_array()
    {
        $array = ['id' => 22];

        $result = get_id_from_variable($array);
        $this->assertEquals($result, 22);
    }

    /** @test */
    public function can_get_response_as_collection_of_objects()
    {
        $response = [
            'data' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $result = response_to_collect($response, Address::class);

        $this->assertEquals(Collection::class, get_class($result));
        $this->assertEquals(3, $result->count());
        $this->assertEquals(get_class($result->first()), Address::class);
    }

    /** @test */
    public function can_get_response_collection_of_items()
    {
        $response = [
            'data' =>  [
                "192.168.1.0/27",
                "192.168.1.32/27",
                "192.168.1.64/27",
                "192.168.1.96/27",
                "192.168.1.128/27",
                "192.168.1.160/27",
                "192.168.1.192/27",
                "192.168.1.224/27",
            ]
            ,
        ];

        $result = response_to_collect($response);

        $this->assertEquals(Collection::class, get_class($result));
        $this->assertEquals(8, $result->count());
        $this->assertEquals($result->first(), '192.168.1.0/27');
    }
}

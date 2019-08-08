<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Models\Address;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class ModelTest extends PhpIPAMTestCase
{
    /** @test */
    public function can_fill_model()
    {
        $data = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => [
                'value3_1',
                'value3_2',
            ],
            'param4' => [
                'param4_1' => [
                    'value4_1_1',
                    'value4_1_2',
                ],
                'param4_2' => 'value4_2',
            ],
        ];

        $address = new Address($data);

        $this->assertEquals($address->param1, 'value1');
        $this->assertEquals($address->param2, 'value2');

        $this->assertTrue(is_array($address->param3));
        $this->assertEquals($address->param3[0], 'value3_1');
        $this->assertEquals($address->param3[1], 'value3_2');

        $this->assertTrue(is_object($address->param4));
        $this->assertTrue(is_array($address->param4->param4_1));
        $this->assertEquals($address->param4->param4_1[0], 'value4_1_1');
        $this->assertEquals($address->param4->param4_1[1], 'value4_1_2');
        $this->assertEquals($address->param4->param4_2, 'value4_2');
    }

    /** @test */
    public function can_get_array_from_object()
    {
        $address = new Address([
            'ip' => '192.168.1.1',
            'subnets' => [
                'subnet1',
                'subnet2'
            ]
        ]);

        $array = $address->toArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals($array['ip'], '192.168.1.1');
        $this->assertEquals($array['subnets'][0], 'subnet1');
        $this->assertEquals($array['subnets'][1], 'subnet2');
    }

    /** @test */
    public function can_get_specific_parameters_with_only_method()
    {
        $address = new Address([
            'ip' => '192.168.1.1',
            'subnets' => [
                'subnet1',
                'subnet2'
            ],
            'test' => 'hey!'
        ]);

        $only = $address->only(['ip', 'subnets']);

        $this->assertTrue(is_array($only));
        $this->assertArrayHasKey('ip', $only);
        $this->assertArrayHasKey('subnets', $only);
        $this->assertArrayNotHasKey('test', $only);
        $this->assertEquals($only['ip'], '192.168.1.1');
        $this->assertEquals($only['subnets'][0], 'subnet1');
        $this->assertEquals($only['subnets'][1], 'subnet2');
    }

    /** @test */
    public function can_get_all_parameters_without_specific_ones()
    {

        $address = new Address([
            'ip' => '192.168.1.1',
            'subnets' => [
                'subnet1',
                'subnet2'
            ],
            'test' => 'hey!'
        ]);

        $except = $address->except('test');

        $this->assertTrue(is_array($except));
        $this->assertArrayHasKey('ip', $except);
        $this->assertArrayHasKey('subnets', $except);
        $this->assertArrayNotHasKey('test', $except);
        $this->assertEquals($except['ip'], '192.168.1.1');
        $this->assertEquals($except['subnets'][0], 'subnet1');
        $this->assertEquals($except['subnets'][1], 'subnet2');
    }
}

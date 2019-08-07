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
}

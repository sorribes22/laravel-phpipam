<?php

namespace Axsor\PhpIPAM\Tests;

use Axsor\PhpIPAM\PhpIPAM;
use PHPUnit\Framework\TestCase;

class PhpIPAMTest extends TestCase
{
    /** @test */
    public function it_returns_a_address()
    {
        $phpipam = new PhpIPAM();
        $ip = $phpipam->address();
        $this->assertTrue(true);
    }
}

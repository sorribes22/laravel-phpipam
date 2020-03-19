<?php

namespace Axsor\PhpIPAM\Tests\Unit;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use Axsor\PhpIPAM\Tests\PhpIPAMTestCase;

class PhpIPAMTest extends PhpIPAMTestCase
{
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('phpipam', [
            'default' => [
                'url' => 'https://myphpipam.com/api',
                'user' => 'user',
                'pass' => 'password',
                'app' => 'app',
                'token' => 'token',
                'verify_cert' => true,
            ],
            'server_2' => [
                'url' => 'https://server2.com/api',
                'user' => 'user2',
                'pass' => 'password2',
                'app' => 'app2',
                'token' => 'token2',
                'verify_cert' => true,
            ],
        ]);
    }

    public function test_can_change_connection()
    {
        $config = PhpIPAM::getConfig();
        $this->assertEquals($config, [
            'url' => 'https://myphpipam.com/api',
            'user' => 'user',
            'pass' => 'password',
            'app' => 'app',
            'token' => 'token',
            'verify_cert' => true,
        ]);

        $config = PhpIPAM::connect('server_2')->getConfig();
        $this->assertEquals($config, [
            'url' => 'https://server2.com/api',
            'user' => 'user2',
            'pass' => 'password2',
            'app' => 'app2',
            'token' => 'token2',
            'verify_cert' => true,
        ]);
    }

    public function test_can_reset_default_connection()
    {
        $config = PhpIPAM::connect('server_2')->getConfig();
        $this->assertEquals($config, [
            'url' => 'https://server2.com/api',
            'user' => 'user2',
            'pass' => 'password2',
            'app' => 'app2',
            'token' => 'token2',
            'verify_cert' => true,
        ]);

        PhpIPAM::resetConnection();
        $config = PhpIPAM::getConfig();
        $this->assertEquals($config, [
            'url' => 'https://myphpipam.com/api',
            'user' => 'user',
            'pass' => 'password',
            'app' => 'app',
            'token' => 'token',
            'verify_cert' => true,
        ]);
    }

    public function test_can_get_connection()
    {
        $this->assertEquals('default', PhpIPAM::getConnection());
        $this->assertEquals('server_2', PhpIPAM::connect('server_2')->getConnection());
    }

    public function test_can_get_cache_key()
    {
        $this->assertEquals('phpipam-default', PhpIPAM::getCacheKey());
        $this->assertEquals('phpipam-server_2', PhpIPAM::connect('server_2')->getCacheKey());
    }
}

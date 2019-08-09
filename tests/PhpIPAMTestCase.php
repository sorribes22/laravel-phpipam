<?php

namespace Axsor\PhpIPAM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Axsor\PhpIPAM\Facades\PhpIPAM;
use GuzzleHttp\Handler\MockHandler;

class PhpIPAMTestCase extends \Orchestra\Testbench\TestCase
{
    protected $client;

    protected $mock;

    /**
     * Creates MockHandler with "login" response and initialitzes PhpIPAM with a new Client.
     */
    protected function startMocker()
    {
        $this->mock = new MockHandler([
            new Response(200, [], '{"code":200,"success":true,"data":{"token":"EmME%jz+HQSiR0z+qJIJ+$cP","expires":"2019-08-09 17:09:59"},"time":0.032}'),
        ]);

        $handler = HandlerStack::create($this->mock);

        $this->client = new Client(['handler' => $handler]);

        PhpIPAM::setClient($this->client);
    }

    public function appendResponse(string $response)
    {
        $this->mock->append(new Response(200, [], $response));
    }

    protected function getPackageProviders($app)
    {
        return ['Axsor\PhpIPAM\PhpIPAMServiceProvider'];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('phpipam', [
            'url' => 'https://myphpipam.com/api',
            'user' => 'user',
            'pass' => 'password',
            'app' => 'app',
            'token' => 'token',
        ]);
    }
}

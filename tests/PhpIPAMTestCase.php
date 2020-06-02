<?php

namespace Axsor\PhpIPAM\Tests;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class PhpIPAMTestCase extends \Orchestra\Testbench\TestCase
{
    protected $client;

    /**
     * @var \GuzzleHttp\Handler\MockHandler
     */
    protected $mock;

    /**
     * Creates MockHandler with "login" response and initialitzes PhpIPAM with a new Client.
     */
    protected function startMocker()
    {
        $this->mock = new MockHandler();

        $this->appendLoginResponse();

        $handler = HandlerStack::create($this->mock);

        $this->client = new Client(['handler' => $handler]);

        PhpIPAM::setClient($this->client);
    }

    public function appendResponse(string $response)
    {
        $this->mock->append(new Response(200, [], $response));
    }

    public function appendLoginResponse()
    {
        $this->mock->append($this->getLoginResponse());
    }

    public function getLoginResponse()
    {
        $expirationDate = date('Y-m-d H:m:s', strtotime('+6 hours'));

        return new Response(200, [], '{"code":200,"success":true,"data":{"token":"EmME%jz+HQSiR0z+qJIJ+$cP","expires":"'.$expirationDate.'"},"time":0.032}');
    }

    protected function getPackageProviders($app)
    {
        return ['Axsor\PhpIPAM\PhpIPAMServiceProvider'];
    }

    protected function getEnvironmentSetUp($app)
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
        ]);
    }
}

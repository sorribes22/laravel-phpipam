<?php

namespace Axsor\PhpIPAM\Http\Requests;

use Axsor\PhpIPAM\Facades\PhpIPAM;
use Illuminate\Support\Facades\Cache;
use Axsor\PhpIPAM\Exceptions\BadCredentialsException;

class Connector
{
    private $config;

    private $headers;

    public function __construct()
    {
        $this->config = PhpIPAM::getConfig();

        $this->configHeaders();
    }

    protected function get($uri)
    {
        return $this->call('GET', $uri);
    }

    protected function post($uri, $payload)
    {
        return $this->call('POST', $uri, $payload);
    }

    protected function patch($uri, $payload)
    {
        return $this->call('PATCH', $uri, $payload);
    }

    protected function delete($uri)
    {
        return $this->call('DELETE', $uri);
    }

    private function call($method, $uri, $payload = [])
    {
        $response = PhpIPAM::getClient()->$method($this->config['url'].'/'.$this->config['app'].'/'.$uri, [
            'headers' => $this->headers,
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function configHeaders()
    {
        $cachedData = null;

        if (Cache::has('phpipam')) {
            $cachedData = Cache::get('phpipam');

            if ($cachedData['expires'] < date('Y-m-d h:i:s')) {
                $cachedData = null;
            }
        }

        if (! $cachedData) {
            $token = $this->login();
        }

        $this->headers = [
            'token' => $cachedData ? $cachedData['token'] : $token,
        ];
    }

    /**
     * Tries to login into PhpIPAM and stores API token into laravel Cache.
     *
     * @return mixed Token to connect to PhpIPAM
     * @throws \Axsor\PhpIPAM\Exceptions\BadCredentialsException
     */
    private function login()
    {
        $response = PhpIPAM::getClient()->post($this->config['url'].'/'.$this->config['app'].'/user/', [
            'auth' => [
                $this->config['user'],
                $this->config['pass'],
            ],
            'headers' => [
                'token' => $this->config['token'],
            ],
            'json' => [],
        ]);

        if ($response->getStatusCode() != 200) {
            throw new BadCredentialsException();
        }
        //dump($response->getBody()->getContents());
        $payload = json_decode($response->getBody()->getContents(), true)['data'];

        Cache::set('phpipam', $payload);

        return $payload['token'];
    }
}

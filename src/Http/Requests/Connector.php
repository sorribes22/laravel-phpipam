<?php

namespace Axsor\PhpIPAM\Http\Requests;

use PhpIPAM;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Axsor\PhpIPAM\Exceptions\BadCredentialsException;

class Connector
{
    private $config;

    private $client;

    public function __construct()
    {
        $this->config = PhpIPAM::getConfig() ?: config('phpipam');

        $this->instanceClient();
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
        $response = $this->client->$method($this->config['url'].'/'.$this->config['app'].'/'.$uri, [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Initializes GuzzleHttp\\Client.
     */
    private function instanceClient()
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

        $this->client = new Client([
            'headers' => [
                'token' => $cachedData ? $cachedData['token'] : $token,
            ],
        ]);
        // {"token":"%NCo6dIBMVexgDH2sUCDmDKD","expires":"2019-08-07 17:26:31"}
    }

    /**
     * Tries to login into PhpIPAM and stores API token into laravel Cache.
     *
     * @return mixed Token to connect to PhpIPAM
     * @throws \Axsor\PhpIPAM\Exceptions\BadCredentialsException
     */
    private function login()
    {
        $response = (new Client())->post($this->config['url'].'/'.$this->config['app'].'/user/', [
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
        $payload = json_decode($response->getBody()->getContents(), true)['data'];

        Cache::put('phpipam', $payload);

        return $payload['token'];
    }
}

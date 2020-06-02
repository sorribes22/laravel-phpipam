<?php

namespace Axsor\PhpIPAM\Http\Requests;

use Axsor\PhpIPAM\Exceptions\BadCredentialsException;
use Axsor\PhpIPAM\Facades\PhpIPAM;
use Illuminate\Support\Facades\Cache;

class Connector
{
    const SUCCESS_CODE = 200;
    const UNAUTHORIZED_CODE = 401;

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

    private function call($method, $uri, $payload = [], $firstTry = false)
    {
        try {
            $response = PhpIPAM::getClient()->$method($this->config['url'].'/'.$this->config['app'].'/'.$uri, [
                'headers' => $this->headers,
                'json' => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if (! $firstTry && $e->getCode() == self::UNAUTHORIZED_CODE) {
                Cache::forget(PhpIPAM::getCacheKey());
                $this->configHeaders();

                return $this->call($method, $uri, $payload, true);
            } else {
                throw $e;
            }
        }
    }

    private function configHeaders()
    {
        $cachedData = null;

        if (Cache::has(PhpIPAM::getCacheKey())) {
            $cachedData = Cache::get(PhpIPAM::getCacheKey());

            if ($cachedData['expires'] <= date('Y-m-d h:i:s')) {
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

        if ($response->getStatusCode() != self::SUCCESS_CODE) {
            throw new BadCredentialsException();
        }

        $payload = json_decode($response->getBody()->getContents(), true)['data'];

        Cache::set(PhpIPAM::getCacheKey(), $payload);

        return $payload['token'];
    }
}

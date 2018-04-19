<?php

namespace Axsor\LaravelPhpIPAM;


use Axsor\LaravelPhpIPAM\Exceptions\PhpIPAMBadCredentials;
use Axsor\LaravelPhpIPAM\Exceptions\PhpIPAMConfigNotFound;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class Connection
{
    /**
     * PhpIPAM url
     * @var
     */
    protected static $url;

    /**
     * PhpIPAM app name
     * @var
     */
    protected static $app;

    /**
     * PhpIPAM user name auth
     * @var
     */
    protected static $user;

    /**
     * PhpIPAM user password auth
     * @var
     */
    protected static $pass;

    /**
     * PhpIPAM api key
     * @var
     */
    protected static $key;

    /**
     * Token returned from PhpIPAM when login success
     * @var
     */
    protected static $auth_token;


    /**
     * Client to send HTTP requests
     *
     * @var \GuzzleHttp\Client
     */
    protected static $client;



    public function __construct()
    {
        if (!Config::has("phpipam.url")
            || !Config::has("phpipam.app")
            || !Config::has("phpipam.user")
            || !Config::has("phpipam.pass")
            || !Config::has("phpipam.key")
        )
        {
            throw new PhpIPAMConfigNotFound;
        } else
        {
            self::$url = config("phpipam.url");

            self::$app = config("phpipam.app");

            self::$user = config("phpipam.user");

            self::$pass = config("phpipam.pass");

            self::$key = config("phpipam.key");

            self::$client = new Client;
        }
    }



    public static function get($uri)
    {
        return self::request('get', $uri);
    }

    public static function head($uri)
    {
        return self::request('head', $uri);
    }

    public static function post($uri, $data = [])
    {
        return self::request('post', $uri, $data);
    }

    public static function put($uri, $data)
    {
        return self::request('put', $uri, $data);
    }

    public static function delete($uri)
    {
        return self::request('delete', $uri);
    }

    public static function patch($uri, $data)
    {
        return self::request('patch', $uri, $data);
    }


    /**
     * Send request to PhpIPAM
     *
     * @param $method ['get', 'head', 'post', 'put', 'delete', 'patch']
     * @param $uri String path added to base url
     * @param array $payload data to post/put/patch
     * @return mixed
     * @throws PhpIPAMBadCredentials
     */
    protected static function request($method, $uri, $payload = [])
    {
        if (self::getAuthenticatedToken())
        {
            return json_decode(self::$client->$method(self::$url."/".self::$app."/".$uri, [
                'headers' => [
                    'token' => self::$auth_token
                ],
                'json' => $payload
            ])->getBody()->getContents(), true);
        } else throw new PhpIPAMBadCredentials("Invalid username or password.", 401);
    }

    /**
     * Authenticates on PhpIPAM server and gets token to use API
     *
     * @return bool
     */
    private static function getAuthenticatedToken()
    {
        $response = self::$client->post(self::$url."/".self::$app."/user/", [
            'auth' => [
                self::$user,
                self::$pass
            ],
            'headers' => [
                'token' => self::$key
            ],
            'json' => []
        ]);

        if ($response->getStatusCode() == 200)
        {
            $body = json_decode($response->getBody()->getContents(), true)['data'];

            self::$auth_token = $body['token'];

            return true;
        }

        return false;
    }
}

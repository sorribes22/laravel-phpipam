<?php

namespace Axsor\LaravelPhpIPAM;


use Axsor\LaravelPhpIPAM\Exceptions\PhpIPAMConfigNotFound;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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

    protected static $auth_token;

//    protected static $auth_expires;

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
//            || !Config::has("phpipam.auth_token")
//            || !Config::has("phpipam.auth_expires")
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

//            self::$auth_token = config("phpipam.auth_token");
//
//            self::$auth_expires = config("phpipam.auth_expires");

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
        }
    }

//    /**
//     * Check if auth_token is not empty and if token is not expired.
//     *
//     * Try to get token if not.
//     *
//     * @return bool Has valid authenticated token?
//     */
//    private static function checkAuthenticatedToken()
//    {
//        if (self::$auth_token && self::$auth_expires)
//        {
//            // `!Carbon::parse(self::$auth_expires)->isPast()` not working
////            if ((bool) Carbon::now()->toDateTimeString() <= self::$auth_expires)
////            {
////                return true;
////            }
//        }
//
//        return self::getAuthenticatedToken();
//    }



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
//            self::$auth_expires = $body['expires'];

//            self::changeEnvironmentValue("PHPIPAM_API_AUTH_TOKEN", self::$auth_token, true);
//            self::changeEnvironmentValue("PHPIPAM_API_AUTH_EXPIRES", self::$auth_expires, true);

            return true;
        }

        return false;
    }

//    /**
//     * Function getted from:
//     * https://stackoverflow.com/questions/40450162/how-to-set-env-values-in-laravel-programmatically-on-the-fly#46396076
//     *
//     * @param $envKey
//     * @param $envValue
//     * @param bool $double_commed
//     */
//    private static function changeEnvironmentValue($envKey, $envValue, $double_commed = false)
//    {
//        $envFile = app()->environmentFilePath();
//        $str = file_get_contents($envFile);
//
//        $oldValue = env($envKey);
//
//        if ($double_commed)$str = str_replace("{$envKey}=\"{$oldValue}\"", "{$envKey}=\"{$envValue}\"", $str);
//        else $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
//
//        $fp = fopen($envFile, 'w');
//        fwrite($fp, $str);
//        fclose($fp);
//    }
}

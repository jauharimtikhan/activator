<?php

namespace JoeActivate;

use GuzzleHttp\Client;

class Activator
{
    // protected static string $baseUrl = 'https://laravel-activator.jnologi.my.id';
    protected static string $baseUrl = 'http://localhost:8000';

    public static function init(string $token, array $headerRequest)
    {
        $client = new Client();

        $response = $client->post(self::$baseUrl . '/api/activator/getstate/' . $token, $headerRequest);
        $result = json_decode($response->getBody(), true);
        if ($result['status'] !== 200) {
            throw new \Exception($result['message']);
        }

        if ($result['data']->status == true) {
            return true;
        }
    }
}

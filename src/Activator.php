<?php

namespace JoeActivate;

use GuzzleHttp\Client;

class Activator
{
    // protected static string $baseUrl = 'https://laravel-activator.jnologi.my.id';
    protected static string $baseUrl = 'http://localhost:8000';
    protected static ?string $token;
    protected static ?array $key;

    public function __construct($token = null, $key = [])
    {
        self::$token = $token;
        self::$key = $key;
    }

    public static function init()
    {
        try {
            $client = new Client();
            $response = $client->get(self::$baseUrl . '/api/activator/getstate/' . self::$token, self::$key);
            $result = json_decode($response->getBody(), true);
            if ($result['data']['status'] === false) {
                echo self::html($result['status'], 'd-block', 'd-none');
                exit();
            } else {
                return true;
            }
            if ($result['data']['status'] !== 200) {
                echo self::html($result['message'], 'd-block', 'd-none');
                exit();
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            if ($th->getCode() === 401) {
                echo self::html("Your Token is invalid", 'd-none', 'd-block');
                exit();
            } elseif ($th->getCode() === 404) {
                echo self::html("Your Token Not Found", 'd-none', 'd-block');
                exit();
            } else {
                echo self::html($th->__tostring(), 'd-none', 'd-block');
                exit();
            }
        }
    }

    protected static function html(mixed $state, string $class, string $errorClass = 'd-none'): string
    {
        $html = <<<HTML
                                 <!doctype html>
                            <html lang="en">
                            <head>
                                <meta charset="utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <title>Aktivasi Produk</title>
                                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                                    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                                <style>
                                    .aktivasi-img {
                                        width: 100%;
                                        height: 200px;
                                        image-resolution: from-image;
                                        background-position: center;
                                        background-size: contain;
                                        background-repeat: no-repeat;
                                        background-image: url('https://raw.githubusercontent.com/jauharimtikhan/README.md/restrict/restrict.png');
                                    }
                                    ._container{
                                        min-height: 100vh;
                                        display: flex;
                                        align-items: start;
                                        justify-content: center;
                                    }
                                </style>
                            </head>

                            <body data-bs-theme="dark">
                                <div class="_container _py-5">
                                    <div class="_card">
                                        
                                        <div class="aktivasi-img"></div>
                                        <h2 class="text-center text-danger $class">Silahkan Hubungi Developer Terlebih Dahulu, Untuk Mengaktifkan Project
                                            ini.</h2>
                                            <div class="bg-body-tertiary mt-3 p-2 rounded $errorClass">
                                                <h2 class="text-center text-warning">$state</h2>
                                            </div>
                                    </div>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
                                </script>
                            </body>

                            </html>
                HTML;
        return $html;
    }
}

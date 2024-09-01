<?php

namespace JoeActivate;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class Activator
{
    // protected static string $baseUrl = 'https://laravel-activator.jnologi.my.id';
    protected static string $baseUrl = 'http://localhost:8000';

    public static function init(string $token, array $headerRequest, $next)
    {
        $client = new Client();

        $response = $client->post(self::$baseUrl . '/api/activator/getstate/' . $token, $headerRequest);
        $result = json_decode($response->getBody(), true);
        if ($result['status'] !== 200) {
            return $result;
        }

        if ($result['data']['status'] === false) {
            $symRes =  new Response(self::html(), 200, [
                'cache-control' => 'private',
                'date' => date('D, d M Y H:i:s \G\M\T'),
                'Content-Type' => 'text/html; charset=UTF-8',
            ]);
            return $next($symRes);
        }
        return true;
    }

    protected static function html(): string
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

                            <body>
                                <div class="_container _py-5">
                                    <div class="_card">
                                        <div class="aktivasi-img"></div>
                                        <h2 class="text-center text-danger">Silahkan Hubungi Developer Terlebih Dahulu, Untuk Mengaktifkan Project
                                            ini.</h2>
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

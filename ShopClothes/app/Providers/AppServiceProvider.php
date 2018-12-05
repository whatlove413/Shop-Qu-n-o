<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        app()->bind("guzzleClient", function ($app, $headerParams = null) {
            // Lấy headers
            $header = app("request")->header();
            // Lấy user agent
            $ua = $header["deviceid"][0] ? $header["deviceid"][0] : null;
            $token = $header["authorization"][0] ? $header["authorization"][0] : null;

            $client = new \GuzzleHttp\Client([
                "headers" => [
                    "deviceid" => $ua,
                    "Authorization" => $token,
                ],
            ]);
            // Nếu bổ sung thêm header
            if ($headerParams) {
                $headerDefaults = array_merge($headerDefaults, $headerParams);
            }

            $client = new \GuzzleHttp\Client([
                "headers" => $headerDefaults,
                "defaults" => ['verify' => false],
            ]);


            return $client;
        });

        $client = app("guzzleClient");
        $res = $client->request('GET', 'api.local.com/v1/category/');
        $headers = $res->getHeaders();
        $data = $res->getBody()->getContents();
        $data = json_decode($data, true)['data'];
        View::share('category', $data);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

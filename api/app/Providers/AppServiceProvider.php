<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use Validator;
use View;

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
        if (env('APP_ENV') !== 'local' and env('APP_ENV') !== 'develop') {
            $this->app['request']->server->set('HTTPS', true);
        }
        $this->app->bind('sms', function ($app) {
            return new \App\Helpers\SMS();
        });

        $this->app->bind('filter', function ($app) {
            return new \App\Helpers\Filter();
        });
        Validator::extend('phone_number', function ($attribute, $value, $parameters) {
            return substr($value, 0, 2) == '09';
        });
        $this->app->bind('image', function ($app) {
            return new \App\Helpers\Image();
        });
        $agent = new Agent();
        $isPhone = $agent->isPhone();
        view()->share('isPhone', $isPhone);

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

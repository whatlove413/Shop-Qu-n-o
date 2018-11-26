<?php
namespace App\Providers;

use App\Auth\AdminProvider;
use Illuminate\Support\ServiceProvider;
use Auth;

class AdminAuthProvider extends ServiceProvider
{
	/**
     * Boot the services for the application.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('member', function($app, array $config) {
            return new AdminProvider();
        });
    }

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}
}
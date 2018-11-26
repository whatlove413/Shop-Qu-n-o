<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		foreach (glob(app_path().'/../core/Helpers/*.php') as $filename){
			
			require_once($filename);
		}

		foreach (glob(app_path().'/Helpers/*Func.php') as $filename){
			
			require_once($filename);
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [

		];
	}
}

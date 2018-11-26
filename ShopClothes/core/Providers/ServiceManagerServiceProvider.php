<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Foundation\AliasLoader;

class ServiceManagerServiceProvider extends ServiceProvider
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
    	$this->app->singleton("service.manager", function() {
    		 
    		return \App::make(\Core\ServiceManager\ServiceManager::class);
    	});
    	
    	$this->app->register( \Services\ServiceServiceProvider::class );
    	
    	$loader = AliasLoader::getInstance();
    	$loader->alias("ServiceManager", \Core\ServiceManager\Facades\ServiceManager::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
        	"service.manager"
        ];
    }
}

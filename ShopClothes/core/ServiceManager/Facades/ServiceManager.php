<?php
namespace Core\ServiceManager\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceManager extends Facade
{

	/**
	 * Get the registered name of the component.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'service.manager';
	}
}

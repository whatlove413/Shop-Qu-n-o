<?php

namespace Core\ServiceManager\Traits;

use Core\Storages\InstanceStorage;
use Core\ServiceManager\Exceptions\InvalidServiceException;

/**
 * Class Service
 *
 * @package Core\ServiceManager\Traits
 */
trait ServiceManager
{

    /**
     * Gets service
     * - if instance exits in temporary storage, return it
     * - create service
     * - if service is not singleton, cache it to temporary array
     * - return service class
     *
     * @param string $serviceName
     * @param array $params
     * @return mixed|null
     */
    public function getService($serviceName, $params = [])
    {
    	
    	$serviceName = $this->checkServiceName($serviceName);
    	
        if (InstanceStorage::has($serviceName)) {

            return InstanceStorage::get($serviceName);
        }

        $service = $this->getServicePath($serviceName);

        $this->checkService($service);

        return $this->createService($serviceName, $service, $params);
    }
    
    private function checkServiceName( $serviceName ) {
    	
    	if( strpos($serviceName, '.') === false ) {
    		
    		$stringEx = array_filter(explode("\\", $serviceName));
    	} else {
    		
    		$stringEx = array_filter(explode(".", $serviceName));
    	}
    	
    	$stringEx = array_values($stringEx);
    	
    	if( $stringEx[0] !== "Services" ) {
    		
    		array_unshift( $stringEx, "Services" );
    	}
    	
    	$stringEx = implode(".", $stringEx);
    	
    	return $stringEx;
    }

    /**
     * Gets service from services array
     *
     * @param
     *        	$serviceName
     * @return string
     * @throws \Exception
     */
    public function getServicePath($serviceName)
    {
    	
    	$serviceName = explode(".", $serviceName);
    	$serviceName = "\\" . implode("\\", $serviceName);
    	
        return $serviceName;
        // $services = config("services.services") ?? [];
        // if (!in_array($serviceName, array_keys($services)))
        // throw new InvalidServiceException(sprintf("Service not implemented [%s]", $serviceName));
        // return $services[$serviceName];
    }

    /**
     * Checks if service class exists
     *
     * @param string $service
     * @throws InvalidServiceException
     */
    private function checkService($service)
    {

        if (!class_exists($service)) {

            throw new InvalidServiceException(sprintf("Service class not found [%s]", $service));
        }
    }

    /**
     * Creates new service
     * - if service is set as singleton it wont be stored to temporary array
     *
     * @param string $serviceName
     * @param string $service
     * @param array $params
     * @return string
     */
    private function createService($serviceName, $service, $params = null)
    {

        //$nonSingletons = config ( 'service.non-singleton' ) ?? [ ];

        $serviceClass = \App::make($service, $params);

        //if ( ! in_array ( $serviceName, $nonSingletons ) ) {

        InstanceStorage::set($serviceName, $serviceClass);
        //}

        return $serviceClass;
    }
}

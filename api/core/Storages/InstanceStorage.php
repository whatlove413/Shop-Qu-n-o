<?php

namespace Core\Storages;

use Core\Contracts\Storage;

/**
 * Stores every instances created via Core\Services\Traits\Service
 * Class InstanceStorage
 * @package Core\Services\Storages\InstaceStorage
 */
class InstanceStorage implements Storage
{

    /**
     * Static array of instances
     * @var array
     */
    public static $_instances = [];

    /**
     * Check if name is in storage
     * @param string $serviceName
     * @return bool
     */
    public static function has($instanceName)
    {
        return in_array($instanceName, array_keys(self::$_instances));
    }

    /**
     * Gets instance if exists
     * @param string $serviceName
     * @return mixed|null
     */
    public static function get($instanceName)
    {
        return self::$_instances[$instanceName] ? self::$_instances[$instanceName] : null;
    }

    /**
     * @param string $serviceName
     * @param $instance
     */
    public static function set($instanceName, $instance)
    {
        self::$_instances[$instanceName] = $instance;
    }
}

<?php

namespace Core\Contracts;

interface Storage
{

    public static function has($serviceName);

    public static function get($serviceName);

    public static function set($serviceName, $instance);
}

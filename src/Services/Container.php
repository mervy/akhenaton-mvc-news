<?php

namespace Akhenaton\Services;

use Akhenaton\Exceptions\ContainerException;

class Container
{
    protected static $instances = [];

    public static function set($key, $value): void
    {
        static::$instances[$key] = $value;
    }

    public static function get($key)
    {
        if (!isset(static::$instances[$key])) {
            throw new ContainerException('No instance found for key: ' . $key);
        }
        return static::$instances[$key];
    }
}

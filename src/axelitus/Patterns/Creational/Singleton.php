<?php
/**
 * Part of composer package: axelitus/patterns
 *
 * @package     axelitus\Patterns
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/patterns
 */

namespace axelitus\Patterns\Creational;

use axelitus\Patterns\Utils;
use axelitus\Patterns\Interfaces;
use axelitus\Patterns\Exceptions;

abstract class Singleton
{
    protected static $instances = [];

    protected static $cache = [];

    protected function __construct()
    {
    }

    public static function instance()
    {
        $class = get_called_class();
        if (!array_key_exists($class, static::$instances)) {
            if (!array_key_exists($class, static::$cache)) {
                static::$cache[$class]['forgeable'] = Utils::class_implements(
                    $class,
                    'axelitus\Patterns\Interfaces\Forgeable'
                );
            }

            $args = func_get_args();
            if(static::$cache[$class]['forgeable'])
            {
                static::$instances[$class] = call_user_func_array([$class, 'forge'], $args);
            }
            else
            {
                $ref = new \ReflectionClass($class);
                $ctor = $ref->getConstructor();
                $ctor->setAccessible(true);

                static::$instances[$class] = $ref->newInstanceWithoutConstructor();
                $ctor->invokeArgs(static::$instances[$class], $args);
            }
        }

        return static::$instances[$class];
    }

    public static function dispose()
    {
        $class = get_called_class();
        unset(static::$instances[$class]);
    }

    public static function renew()
    {
        $class = get_called_class();
        $args = func_get_args();

        static::dispose();
        return call_user_func_array([$class, 'instance'], $args);
    }

    /**
     * No serialization allowed
     *
     * @final
     * @throws      Exceptions\MethodNotAllowedException
     */
    final public function __sleep()
    {
        throw new Exceptions\MethodNotAllowedException("No serialization allowed.", E_USER_ERROR);
    }

    /**
     * No unserialization allowed
     *
     * @final
     * @throws      Exceptions\MethodNotAllowedException
     */
    final public function __wakeup()
    {
        throw new Exceptions\MethodNotAllowedException("No unserialization allowed.", E_USER_ERROR);
    }

    /**
     * No cloning allowed
     *
     * @final
     * @throws      Exceptions\MethodNotAllowedException
     */
    final public function __clone()
    {
        throw new Exceptions\MethodNotAllowedException("No cloning allowed.", E_USER_ERROR);
    }
}

<?php
/**
 * Part of composer package: axelitus/patterns
 *
 * @package     axelitus\Patterns
 * @version     0.3
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/patterns
 */

namespace axelitus\Patterns\Creational;

use axelitus\Patterns\Utils;
use axelitus\Patterns\Interfaces;
use axelitus\Patterns\Exceptions;

/**
 * Class TSingleton
 *
 * Defines a generic Singleton object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class Singleton
{
    /**
     * @type string $T The full qualified class name (FQCN) of the class to be instantiated. This field should be declared in all derived classes with the appropriate class.
     */
    protected static $T = '';

    /**
     * @type array $instances Holds the Singleton instances array map (as the static var is shared amongst all derivable classes).
     */
    protected static $instances = [];

    /**
     * @type array $cache Holds cache information about the classes.
     */
    protected static $cache = [];

    /**
     * Prevents this class from being directly instantiated but allows sub classes to define the needed constructor
     */
    protected function __construct()
    {
    }

    /**
     * Gets the current Singleton instance.
     *
     * Automatically creates an instance if non exists. If one instance already exists, the argument list is ignored.
     *
     * @param mixed $args,... The arguments for creating the Singleton instance.
     *
     * @return Singleton The Singleton instance.
     */
    public static function instance()
    {
        $class = static::$T;
        if (!class_exists($class)) {
            throw new Exceptions\ClassNotFoundException("The class $class was not found.");
        }

        if (!array_key_exists($class, static::$instances)) {
            if (!array_key_exists($class, static::$cache)) {
                static::$cache[$class]['forgeable'] = Utils::class_implements(
                    $class,
                    'axelitus\Patterns\Interfaces\Forgeable'
                );
            }

            $args = func_get_args();
            if (static::$cache[$class]['forgeable']) {
                static::$instances[$class] = call_user_func_array([$class, 'forge'], $args);
            } else {
                $ref = new \ReflectionClass($class);
                $ctor = $ref->getConstructor();
                $ctor->setAccessible(true);

                static::$instances[$class] = $ref->newInstanceWithoutConstructor();
                $ctor->invokeArgs(static::$instances[$class], $args);
            }
        }

        return static::$instances[$class];
    }

    /**
     * Removes the current Singleton instance.
     */
    public static function remove()
    {
        $class = static::$T;
        unset(static::$instances[$class]);
    }

    /**
     * Renews the Singleton instance.
     *
     * It automatically disposes the previously existing instance and creates a new one.
     *
     * @param mixed $args,... The arguments for creating the Singleton instance.
     *
     * @return Singleton The new Singleton instance.
     */
    public static function renew()
    {
        $class = get_called_class();
        $args = func_get_args();

        static::remove();
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

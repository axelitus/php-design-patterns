<?php
/**
 * Part of composer package: axelitus/patterns
 *
 * @package     axelitus\Patterns
 * @version     0.2
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
 * Class TMultiton
 *
 * Defines a generic Multiton object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class TMultiton
{
    /**
     * @type string $T The full qualified class name (FQCN) of the class to be instantiated. This field should be declared in all derived classes with the appropriate class.
     */
    protected static $T = '';

    /**
     * @type array $instances Holds the Multiton instances array map (as the static var is shared amongst all derivable classes).
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
     * Gets the Multiton instance referenced by key.
     *
     * Automatically creates an instance if non exists. If one instance already exists, the argument list is ignored.
     *
     * @param string $key      The key of the Multiton instance to get.
     * @param mixed  $args,... The arguments for creating the Multiton instance.
     *
     * @return Multiton The Multiton instance.
     */
    public static function instance($key = 'default')
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        $class = static::$T;
        if (!class_exists($class)) {
            throw new Exceptions\ClassNotFoundException("The class $class was not found.");
        }

        if (!array_key_exists($class, static::$instances) or !array_key_exists($key, static::$instances[$class])) {
            if (!array_key_exists($class, static::$cache)) {
                static::$cache[$class]['forgeable'] = Utils::class_implements(
                    $class,
                    'axelitus\Patterns\Interfaces\Forgeable'
                );
            }

            $args = array_slice(func_get_args(), 1);
            if (static::$cache[$class]['forgeable']) {
                static::$instances[$class][$key] = call_user_func_array([$class, 'forge'], $args);
            } else {
                $ref = new \ReflectionClass($class);
                $ctor = $ref->getConstructor();
                $ctor->setAccessible(true);

                static::$instances[$class][$key] = $ref->newInstanceWithoutConstructor();
                $ctor->invokeArgs(static::$instances[$class][$key], $args);
            }
        }

        return static::$instances[$class][$key];
    }

    /**
     * Removes the Multiton instance referenced by key.
     *
     * @param string $key      The key of the Multiton instance to remove.
     */
    public static function dispose($key)
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        $class = static::$T;
        unset(static::$instances[$class][$key]);
    }

    /**
     * Renews the Multiton instance referenced by key.
     *
     * It automatically disposes the previously existing instance and creates a new one.
     *
     * @param string $key      The key of the Multiton instance to get.
     * @param mixed  $args,... The arguments for creating the Multiton instance.
     *
     * @return Singleton The new Multiton instance.
     */
    public static function renew($key = 'default')
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        $class = get_called_class();
        $args = [$key] + func_get_args();

        static::remove($key);
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

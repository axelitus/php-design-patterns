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

use axelitus\Base\Exceptions;
use axelitus\Patterns\Interfaces;
use axelitus\Patterns\Utils;

/**
 * Class Multiton
 *
 * Defines a Multiton object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class Multiton
{
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

        $class = get_called_class();
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
     * Renews the Multiton instance referenced by key.
     *
     * It automatically disposes the previously existing instance and creates a new one.
     *
     * @param string $key      The key of the Multiton instance to renew.
     * @param mixed  $args,... The arguments for creating the Multiton instance.
     *
     * @return Multiton The new Multiton instance.
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
     * Removes the Multiton instance referenced by key.
     *
     * @param string $key      The key of the Multiton instance to remove.
     */
    public static function remove($key)
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        $class = get_called_class();
        unset(static::$instances[$class][$key]);
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

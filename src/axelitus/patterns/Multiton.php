<?php
/**
 * Part of the axelitus\patterns package.
 *
 * @package     axelitus\patterns
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/php-patterns
 * @source      https://github.com/axelitus/php-patterns
 */

namespace axelitus\patterns;

/**
 * Class Multiton
 *
 * A base class to implement the Multiton Design Pattern.
 *
 * @package axelitus\patterns
 * @since       0.1     introduced class Multiton
 */
abstract class Multiton
{
    //region Constants

    /**
     * @since   0.1     introduced INIT_METHOD_NAME
     * @type    string      The initialization method name (declaration of this method is optional)
     */
    const INIT_METHOD_NAME = 'init';

    //endregion


    //region Static Attributes

    /**
     * @static
     * @since       0.1     introduced $instances
     * @type    mixed       The multiton's instances array
     **/
    protected static $instances = [];

    //endregion


    //region Constructors

    /**
     * Prevent this class from being instantiated (but allow sub-classes to create new instances).
     *
     * @since       0.1     introduced final protected function __construct()
     */
    final protected function __construct()
    {
    }

    //endregion


    //region Static Methods/Functions

    /**
     * Forges a new instance of this class or returns the existing one identified by key.
     *
     * Forges a new instance of this class or returns the existing one identified by key. The Multitons are
     * key-named to identify them. The parameters are passed along to the initialization method if exists to
     * auto-initialize (configure) the newly created instance. ALL params are passed, the first one being the
     * name (key) of the instance. If no key parameter is given, the default instance is created (identified
     * by the string 'default').
     *
     * @static
     * @since       0.1     introduced public static function instance($key = 'default', $params = null)
     * @param string $key        The instance's key (name)
     * @param mixed $params,... The instance's initialization parameters
     * @return mixed    The newly created instance
     */
    public static function instance($key = 'default', $params = null)
    {
        if (!isset(static::$instances[$key]) or !static::$instances[$key] instanceof static) {
            static::$instances[$key] = new static();

            if (method_exists(static::$instances[$key], static::INIT_METHOD_NAME) and is_callable(
                    array(
                        static::$instances[$key],
                        static::INIT_METHOD_NAME
                    )
                )
            ) {
                call_user_func_array(array(static::$instances[$key], static::INIT_METHOD_NAME), func_get_args());
            }
        }

        return static::$instances[$key];
    }

    /**
     * Kills the given Multiton's instance.
     *
     * Sets the multiton instance identified by key to null, so the next time instance is called with the
     * given key a new instance should be created for that key.
     *
     * @static
     * @since       0.1     introduced public static function kill($key = 'default')
     * @param string $key        The instance's key (name)
     */
    public static function kill($key = 'default')
    {
        static::$instances[$key] = null;
        unset(static::$instances[$key]);
    }

    /**
     * Clears the Multiton's instances array.
     *
     * Sets the instances array to an empty array.
     *
     * @static
     * @since       0.1     introduced public static function clear()
     */
    public static function clear()
    {
        static::$instances = [];
    }

    /**
     * Forges a new Multiton instance identified by the given key replacing the previous one if exists and returns
     * the newly created instance.
     *
     * Forges a new Multiton instance identified by the given key replacing the previous one if exists and returns
     * the newly created instance. The parameters are passed along to the initialization method if exists to
     * auto-initialize (configure) the newly created instance. ALL params are passed, the first one being the
     * name (key) of the instance.
     *
     * @static
     * @since       0.1     introduced public static function reinstance($key = 'default', $params = null)
     * @param string $key        The instance's key (name)
     * @param mixed $params,...     The Multiton's initialization parameters
     * @return mixed    The newly created Multiton's instance
     */
    public static function reinstance($key = 'default', $params = null)
    {
        static::kill($key);
        return call_user_func_array(get_called_class() . '::instance', func_get_args());
    }

    /**
     * Counts the Multiton instances loaded.
     *
     * Returns the number of instances in the Multiton's instances array.
     *
     * @static
     * @since       0.1     introduced public static function count()
     * @return int
     */
    public static function count()
    {
        return count(static::$instances);
    }

    //endregion


    //region Multiton Pattern Enforcement

    /**
     * No serialization allowed
     *
     * @final
     * @since       0.1     introduced final public function __sleep()
     * @throws      MethodNotAllowedException
     */
    final public function __sleep()
    {
        throw new MethodNotAllowedException("No serialization allowed.", E_USER_ERROR);
    }

    /**
     * No unserialization allowed
     *
     * @final
     * @since       0.1     introduced final public function __wakeup()
     * @throws      MethodNotAllowedException
     */
    final public function __wakeup()
    {
        throw new MethodNotAllowedException("No unserialization allowed.", E_USER_ERROR);
    }

    /**
     * No cloning allowed
     *
     * @final
     * @since       0.1     introduced final public function __clone()
     * @throws      MethodNotAllowedException
     */
    final public function __clone()
    {
        throw new MethodNotAllowedException("No cloning allowed.", E_USER_ERROR);
    }

    //endregion
}
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
 * Class Singleton
 *
 * A base class to implement the Singleton Design Pattern.
 *
 * @package axelitus\patterns
 * @since       0.1     introduced class Singleton
 */
abstract class Singleton
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
     * @since       0.1     introduced $instance
     * @type    mixed       The singleton's instance
     **/
    protected static $instance = null;

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
     * Forges a new instance of the singleton or returns the existing one.
     *
     * Forges a new instance of the singleton or returns the existing one. The parameters are passed along to the
     * initialization method if exists to auto-initialize (configure) the newly created singleton instance.
     *
     * @since       0.1     introduced new method instance($params = null)
     * @static
     * @param   mixed $params,...     The singleton's initialization parameters
     * @return  mixed       The newly created singleton's instance
     */
    public static function instance($params = null)
    {
        if (static::$instance == null or !static::$instance instanceof static) {
            static::$instance = new static();

            if (method_exists(static::$instance, static::INIT_METHOD_NAME) and is_callable(
                    array(
                        static::$instance,
                        static::INIT_METHOD_NAME
                    )
                )
            ) {
                call_user_func_array(array(static::$instance, static::INIT_METHOD_NAME), func_get_args());
            }
        }

        return static::$instance;
    }

    /**
     * Kills the singleton's instance.
     *
     * @static
     * @since       0.1     introduced new method kill()
     */
    public static function kill()
    {
        static::$instance = null;
    }

    /**
     * Forges a new instance of the singleton and replaces the existing one.
     *
     * Forges a new instance of the singleton and replaces the existing one. The parameters are passed along to
     * the initialization method if exists to auto-initialize (configure) the singleton.
     *
     * @static
     * @since       0.1     introduced new method reinstance($params = null)
     * @param mixed $params,...     The singleton's initialization parameters
     * @return mixed    The newly created singleton's instance
     */
    public static function reinstance($params = null)
    {
        static::kill();
        return call_user_func_array(get_called_class() . '::instance', func_get_args());
    }

    //endregion


    //region Singleton Pattern Enforcement

    /**
     * No serialization allowed
     *
     * @final
     * @since       0.1     introduced final public function __sleep()
     * @throws      MethodNotAllowedException
     */
    final public function __sleep()
    {
        throw new MethodNotAllowedException("No serialization allowed.");
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
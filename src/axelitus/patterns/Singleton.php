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
     * @since   0.1     introduced const INIT_METHOD_NAME = 'init'
     * @type    string      The initialization method name (declaration of this method is optional)
     */
    const INIT_METHOD_NAME = 'init';

    //endregion


    //region Static Attributes

    /**
     * @static
     * @since       0.1     introduced protected static $instance = null;
     * @type    array       The Singleton's instances dictionary (for derived classes)
     *                      static vars cannot be initialized with arrays, so it must be null.
     **/
    protected static $instances = null;

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
     * Forges a new instance of the Singleton or returns the existing one.
     *
     * Forges a new instance of the Singleton or returns the existing one. The parameters are passed along to the
     * initialization method if exists to auto-initialize (configure) the newly created Singleton instance.
     *
     * @since       0.1     introduced public static function instance($params = null)
     * @static
     * @param   mixed $params,...     The Singleton's initialization parameters
     * @return  mixed       The newly created Singleton's instance
     */
    public static function instance($params = null)
    {
        $derived_class = static::prepare_instances();
        if (empty(static::$instances) or !isset(static::$instances[$derived_class])
            or !(static::$instances[$derived_class] instanceof $derived_class)
        ) {
            // TODO: if implements Forgeable call forge instead
            static::$instances[$derived_class] = new $derived_class($params);

            if (method_exists(static::$instances[$derived_class], static::INIT_METHOD_NAME) and is_callable(
                    array(
                        static::$instances[$derived_class],
                        static::INIT_METHOD_NAME
                    )
                )
            ) {
                call_user_func_array(
                    array(static::$instances[$derived_class], static::INIT_METHOD_NAME),
                    func_get_args()
                );
            }
        }

        return static::$instances[$derived_class];
    }

    /**
     * Kills the Singleton's instance.
     *
     * Sets the Singleton instance to null, so the next time instance() is called a new instance
     * should be created.
     *
     * @static
     * @since       0.1     introduced public static function kill()
     */
    public static function kill()
    {
        $derived_class = static::prepare_instances();
        static::$instances[get_called_class()] = null;
    }

    /**
     * Forges a new instance of the Singleton and replaces the existing one.
     *
     * Forges a new instance of the Singleton and replaces the existing one. The parameters are passed along to
     * the initialization method if exists to auto-initialize (configure) the Singleton.
     *
     * @static
     * @since       0.1     introduced public static function reinstance($params = null)
     * @param mixed $params,...     The Singleton's initialization parameters
     * @return mixed    The newly created Singleton's instance
     */
    public static function reinstance($params = null)
    {
        static::kill();
        return call_user_func_array(get_called_class() . '::instance', func_get_args());
    }

    /**
     * Prepares the instances array.
     *
     * Verifies that the instances array is properly set.
     *
     * @static
     * @since       0.1     introduced protected static function prepare_instances()
     * @return string   Returns the result of the get_called_class() call.
     */
    protected static function prepare_instances()
    {
        $derived_class = get_called_class();
        static::$instances = (isset(static::$instances) and is_array(static::$instances)) ? static::$instances : [];

        return $derived_class;
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
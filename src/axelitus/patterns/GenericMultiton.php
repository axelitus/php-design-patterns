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

use SebastianBergmann\Exporter\Exception;

/**
 * Class GenericMultiton
 *
 * A base class to implement the GenericMultiton Design Pattern. It's the same as the Multiton pattern,
 * but it allows the instances to be of a specified type (defined on the implementing class).
 *
 * @package axelitus\patterns
 * @since       0.1     introduced class GenericMultiton
 */
abstract class GenericMultiton
{
    //region Constants

    /**
     * @since   0.1     introduced const INIT_METHOD_NAME = 'init';
     * @type    string      The initialization method name (declaration of this method is optional)
     */
    const INIT_METHOD_NAME = 'init';

    /**
     * @since   0.1     introduced const INITIALIZED = 'initialized';
     * @type    string      Instances initialization array key
     */
    const INITIALIZED = 'initialized';

    /**
     * @since   0.1     introduced const INSTANCES_CLASS = 'instances_class';
     * @type    string      Instances class array key
     */
    const INSTANCES_CLASS = 'instances_class';

    /**
     * @since   0.1     introduced const INSTANCES_FORGEABLE = 'instances_forgeable';
     * @type    string      Instances forgeable array key
     */
    const INSTANCES_FORGEABLE = 'instances_forgeable';

    /**
     * @since   0.1     introduced const INSTANCES_OBJECTS = 'instances_objects';
     * @type    string      Instances objects array key
     */
    const INSTANCES_OBJECTS = 'instances_objects';

    //endregion


    //region Static Attributes

    /**
     * @static
     * @since       0.1     introduced protected static $instances = [];
     * @type    mixed       The Generic Multiton's instances array
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
     * Initializes the GenericMultiton
     *
     * Verifies that the given $instances_class exists and that it can be instantiated.
     * This method executes only one time regardless of how many times it is called. If this
     * method executes without error, then we can be sure that we can use the $instances_class string.
     *
     * @static
     * @since       0.1     introduced protected static function init()
     * @throws ClassNotFoundException
     * @return string   The result of calling get_called_class()
     */
    protected static function init()
    {
        $derived_class = static::prepare_instances();

        if (!static::$instances[$derived_class][static::INITIALIZED]) {
            try {
                // Ensure we have anything that resembles a class (that means no empty string),
                // otherwise default to the called class name.
                $class = static::$instances[$derived_class][static::INSTANCES_CLASS] = (isset(static::$instances_class) and is_string(
                        static::$instances_class
                    ) and !empty(static::$instances_class)) ? static::$instances_class : static::$instances[$derived_class][static::INSTANCES_CLASS];

                if (!class_exists($class)) {
                    throw new ClassNotFoundException('The given $instances_class [' . static::$instances[$derived_class][static::INSTANCES_CLASS] . '] does not exist.');
                }
            } catch (Exception $ex) {
                throw new ClassNotFoundException('The given $instances_class [' . static::$instances[$derived_class][static::INSTANCES_CLASS] . '] does not exist.', 0, $ex);
            }

            if (Utils::class_implements($class, __NAMESPACE__ . '\Forgeable')) {
                static::$instances[$derived_class][static::INSTANCES_FORGEABLE] = true;
            }

            static::$instances[$derived_class][static::INITIALIZED] = true;
        }

        return $derived_class;
    }


    /**
     * Forges a new instance of this class or returns the existing one identified by key.
     *
     * Forges a new instance of this class or returns the existing one identified by key. The GenericMultitons are
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
        $derived_class = static::init();

        $class = static::$instances[$derived_class][static::INSTANCES_CLASS];
        if (empty(static::$instances) or !isset(static::$instances[$derived_class])
            or !isset(static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key])
            or !(static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key] instanceof $class)
        ) {
            if (static::$instances[$derived_class][static::INSTANCES_FORGEABLE]) {
                static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key] = $class::forge($params);
            } else {
                static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key] = new $class($params);
            }

            if (method_exists(
                    static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key],
                    static::INIT_METHOD_NAME
                ) and is_callable(
                    array(
                        static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key],
                        static::INIT_METHOD_NAME
                    )
                )
            ) {
                call_user_func_array(
                    array(
                        static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key],
                        static::INIT_METHOD_NAME
                    ),
                    func_get_args()
                );
            }
        }

        return static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key];
    }

    /**
     * Kills the given GenericMultiton's instance.
     *
     * Sets the Generic Multiton instance identified by key to null, so the next time instance is called with the
     * given key a new instance should be created for that key.
     *
     * @static
     * @since       0.1     introduced public static function kill($key = 'default')
     * @param string $key        The instance's key (name)
     */
    public static function kill($key = 'default')
    {
        $derived_class = static::init();

        static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key] = null;
        unset(static::$instances[$derived_class][static::INSTANCES_OBJECTS][$key]);
    }

    /**
     * Clears the GenericMultiton's instances array.
     *
     * Sets the instances array to an empty array.
     *
     * @static
     * @since       0.1     introduced public static function clear()
     */
    public static function clear()
    {
        $derived_class = static::init();
        static::$instances[$derived_class][static::INSTANCES_OBJECTS] = [];
    }

    /**
     * Forges a new GenericMultiton instance identified by the given key replacing the previous one if exists and returns
     * the newly created instance.
     *
     * Forges a new GenericMultiton instance identified by the given key replacing the previous one if exists and returns
     * the newly created instance. The parameters are passed along to the initialization method if exists to
     * auto-initialize (configure) the newly created instance. ALL params are passed, the first one being the
     * name (key) of the instance.
     *
     * @static
     * @since       0.1     introduced public static function reinstance($key = 'default', $params = null)
     * @param string $key        The instance's key (name)
     * @param mixed $params,...     The GenericMultiton's initialization parameters
     * @return mixed    The newly created GenericMultiton's instance
     */
    public static function reinstance($key = 'default', $params = null)
    {
        static::kill($key);
        return call_user_func_array(get_called_class() . '::instance', func_get_args());
    }

    /**
     * Counts the GenericMultiton instances loaded.
     *
     * Returns the number of instances in the GenericMultiton's instances array.
     *
     * @static
     * @since       0.1     introduced public static function count()
     * @return int
     */
    public static function count()
    {
        $derived_class = static::init();
        return count(static::$instances[$derived_class][static::INSTANCES_OBJECTS]);
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
        static::$instances[$derived_class] = (isset(static::$instances[$derived_class]) and is_array(
                static::$instances[$derived_class]
            )) ? static::$instances[$derived_class] : [
            static::INITIALIZED => false,
            static::INSTANCES_CLASS => $derived_class,
            static::INSTANCES_FORGEABLE => false,
            static::INSTANCES_OBJECTS => []
        ];

        return $derived_class;
    }

    //endregion


    //region GenericMultiton Pattern Enforcement

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
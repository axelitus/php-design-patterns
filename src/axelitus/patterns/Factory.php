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
 * class Factory
 *
 * A base class to implement the Factory Design Pattern.
 *
 * @package axelitus\patterns
 * @since       0.1     introduced class Factory
 * @uses    Forgeable
 */
abstract class Factory
{
    /**
     * Determines if the given instance is an instanceof the given Forgeable class.
     *
     * The function ensures that the given class exists and implements Forgeable, if not then it fails
     * and throws an InvalidArgumentException.
     *
     * @static
     * @since       0.1     introduced public static function instance_of(Forgeable $instance, $class)
     * @param   Forgeable $instance   The instance to check if is instanceof class
     * @param string $class      The full qualified class name (FQCN) to check if instance is instanceof it
     * @return  bool    Whether the given $instance is instanceof $class
     * @throws \InvalidArgumentException
     */
    public static function instance_of(Forgeable $instance, $class)
    {
        if (($forgeable = __NAMESPACE__ . '\Forgeable') == $class) {
            return true;
        }

        if (!class_exists($class) and !interface_exists($class)) {
            throw new \InvalidArgumentException('The given $class [' . $class . '] does not exist.');
        }

        $implements = class_implements($class);
        if (!in_array($forgeable, $implements)) {
            throw new \InvalidArgumentException('The given $class [' . $class . '] does not implement ' . __NAMESPACE__ . "\\Forgeable.");
        }

        return ($instance instanceof $class);
    }

    //endregion

    //region Methods/Functions

    /**
     * Builds a new Forgeable object
     *
     * @since       0.1     introduced abstract public function build($params = null)
     * @param mixed $params,...     The parameters to build a Forgeable object
     * @return  Forgeable   The newly forged instnace.
     */
    abstract public function produce($params = null);

    //endregion
}
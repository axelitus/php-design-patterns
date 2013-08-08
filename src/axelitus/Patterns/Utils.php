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

namespace axelitus\Patterns;

/**
 * Class Utils
 *
 * A utilities class
 *
 * @package     axelitus\patterns
 * @since       0.1     introduced class Singleton
 */
final class Utils
{
    /**
     * Determines whether a class implements an interface or not.
     *
     * If no interface is given, the class returns the result of the call to class_implements($class)
     *
     * @param object|string $class     An object (class instance) or a string (class name).
     * @param string        $interface The full qualified class name (FQCN) that represents an interface.
     *
     * @return array|bool true or false depending if the class implements the given interface. If no interface is given (null) then an array on success, or FALSE on error.
     */
    final public static function class_implements($class, $interface = null)
    {
        $implements = class_implements($class);

        if (!is_null($interface)) {
            if ($implements !== false and in_array($interface, $implements)) {
                $implements = true;
            } else {
                $implements = false;
            }
        }

        return $implements;
    }
}

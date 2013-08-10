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

namespace axelitus\Patterns\Interfaces;

/**
 * Class Forgeable
 *
 * Defines the interface for an object that is forgeable.
 *
 * @package axelitus\Patterns\Interfaces
 */
interface Forgeable
{
    /**
     * Forges a new object.
     *
     * @param mixed $args,... The arguments to forge the object
     *
     * @return mixed The forged object.
     */
    public static function forge();
}

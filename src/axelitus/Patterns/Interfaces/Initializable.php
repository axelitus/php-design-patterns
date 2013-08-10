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

namespace axelitus\Patterns\Interfaces;

/**
 * Class Initializable
 *
 * Defines an object that is forgeable.
 *
 * @package axelitus\Patterns\Interfaces
 */
interface Initializable
{
    /**
     * Initializes the new object.
     *
     * @param mixed $args,... The arguments to forge the object.
     */
    public function init();
}

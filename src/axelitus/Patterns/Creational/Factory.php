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

use axelitus\Patterns\Interfaces;

/**
 * Class Factory
 *
 * Defines a Factory object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class Factory
{
    /**
     *
     */
    public function __construct()
    {
        // do nothing in the base abstract class.
    }

    /**
     * Builds a new object
     *
     * @param mixed $params,...     The parameters to build an object.
     *
     * @return mixed    The newly created object.
     */
    abstract public function make();
}

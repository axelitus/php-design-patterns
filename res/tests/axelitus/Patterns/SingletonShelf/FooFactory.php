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

namespace axelitus\Patterns\SingletonShelf;

use axelitus\Patterns\Creational;

/**
 * Class FooFactory
 *
 * @package axelitus\Patterns\SingletonShelf
 */
class FooFactory extends Creational\Factory
{
    /**
     * Builds a new object
     *
     * @param mixed $params,...     The parameters to build an object.
     *
     * @return mixed    The newly created object.
     */
    public function make()
    {
        $value = func_get_arg(0);
        return Foo::forge($value);
    }

}

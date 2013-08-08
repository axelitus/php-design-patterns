<?php
/**
 * Part of the axelitus\patterns package.
 *
 * @package     axelitus\patterns\test
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/php-patterns
 * @source      https://github.com/axelitus/php-patterns
 */

namespace axelitus\Patterns;

/**
 * Class Factory_FooBarFactory
 * @package axelitus\patterns\tests
 */
class Factory_FooBarFactory extends Creational\Factory
{
    //region extends axelitus\patterns\Factory

    /**
     * Builds a new interfaces\Forgeable object
     *
     * @since       0.1     introduced public function produce($params = null)
     * @param mixed $params,...     The parameters to build a interfaces\Forgeable object
     * @return mixed
     */
    public function produce($params = null)
    {
        $type = is_string($params) ? $params : 'Foo';
        $name = array_slice(func_get_args(), 1)[0];

        if ($type === 'Foo') {
            return Factory_Foo::forge($name);
        } elseif ($type == 'Bar') {
            return Factory_Bar::forge($name);
        }

        return false;
    }

    //endregion
}

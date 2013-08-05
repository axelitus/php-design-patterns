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

namespace axelitus\patterns\tests;

/**
 * @uses axelitus\patterns
 */
use axelitus\patterns as src;

/**
 * Class Factory_FooFactory
 * @package axelitus\patterns\tests
 */
class Factory_FooFactory extends src\Factory
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
        return Factory_Foo::forge($params);
    }

    //endregion
}
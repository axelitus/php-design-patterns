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
 * Class Factory_BarFactory
 * @package axelitus\patterns\tests
 */
class Factory_BarFactory extends src\Factory
{
    //region extends axelitus\patterns\Factory

    /**
     * Builds a new Forgeable object
     *
     * @since       0.1     introduced public function produce($params = null)
     * @param mixed $params,...     The parameters to build a Forgeable object
     * @return mixed
     */
    public function produce($params = null)
    {
        return Factory_Bar::forge($params);
    }

    //endregion
}
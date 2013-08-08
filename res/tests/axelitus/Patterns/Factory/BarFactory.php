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
 * Class Factory_BarFactory
 * @package axelitus\patterns\tests
 */
class Factory_BarFactory extends Creational\Factory
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
        return Factory_Bar::forge($params);
    }

    //endregion
}
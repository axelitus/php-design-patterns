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
use axelitus\patterns\Forgeable;

/**
 * Class GenericMultiton_ConcreteForgeableInstance
 *
 * An implementation of the Multiton class for running the tests.
 *
 * @package axelitus\patterns\tests
 */
class GenericMultiton_ConcreteForgeableInstance implements src\Forgeable
{
    public $params = [];

    protected function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Forges a new instance of the implementing class.
     *
     * @static
     * @since       0.1     introduced public static function forgeable($params = null)
     * @param mixed $params,...     The parameters to forge the implementing class.
     * @return Forgeable        The newly forged object
     */
    public static function forge($params = null)
    {
        return new static($params);
    }


}
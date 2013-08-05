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
 * Class GenericMultiton_ConcreteInstance
 *
 * An implementation of the Multiton class for running the tests.
 *
 * @package axelitus\patterns\tests
 */
class GenericMultiton_ConcreteInstance
{
    public $params = [];

    public function __construct($params)
    {
        $this->params = $params;
    }
}
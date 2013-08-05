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
 * Class Factory_Foo
 * @package axelitus\patterns\tests
 */
class Factory_Foo implements src\interfaces\Forgeable
{
    //region Attributes

    /**
     * @type string $name   The name of the Foo
     */
    public $name = '';

    //endregion


    //region Constructors

    protected function __construct($name)
    {
        $this->name = $name;
    }

    //endregion


    //region implements axelitus\patterns\interfaces\Forgeable

    /**
     * Forges a new instance of the implementing class.
     *
     * @static
     * @since       0.1     introduced public static function interfaces\Forgeable($params = null)
     * @param mixed $params,...     The parameters to forge the implementing class.
     * @return interfaces\Forgeable        The newly forged object
     */
    public static function forge($params = null)
    {
        $name = is_string($params)? $params : 'MyFoo';
        return new Factory_Foo($name);
    }

    //endregion
}
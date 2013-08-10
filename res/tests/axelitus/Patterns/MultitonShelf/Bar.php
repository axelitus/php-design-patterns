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

namespace axelitus\Patterns\MultitonShelf;

use axelitus\Patterns\Interfaces;

/**
 * Class Bar
 *
 * @package axelitus\Patterns\MultitonShelf
 */
class Bar implements Interfaces\Forgeable
{
    protected $value = '';

    /**
     * @param $value
     */
    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Forges a new object.
     *
     * @param mixed $args,... The arguments to forge the object
     *
     * @return mixed The forged object.
     */
    public static function forge()
    {
        $value = func_get_arg(0);
        return new static($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

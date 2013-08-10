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

namespace axelitus\Patterns;


use axelitus\Patterns\MultitonShelf;

/**
 * Class TestMultitonShelf
 *
 * @package axelitus\patterns\tests
 */
class TestMultitonShelf extends TestCase
{
    /**
     * @type MultitonShelf $shelf The singleton shelf instance.
     */
    protected $shelf;

    public function setUp()
    {
        $this->shelf = MultitonShelf\BarShelf::forge(new MultitonShelf\BarFactory());
    }

    public function test_grab()
    {
        $foo = $this->shelf->grab('foo', 'foo');
        $this->assertEquals('foo', $foo->getValue());

        $foo2 = $this->shelf->grab('bar', 'bar');
        $this->assertEquals('bar', $foo2->getValue());

        $foo3 = $this->shelf->grab('foo', 'bar');
        $this->assertEquals('foo', $foo3->getValue());
    }
}

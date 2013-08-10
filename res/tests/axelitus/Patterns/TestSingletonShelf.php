<?php
/**
 * Part of composer package: axelitus/patterns
 *
 * @package     axelitus\Patterns
 * @version     0.2
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/patterns
 */

namespace axelitus\Patterns;


use axelitus\Patterns\SingletonShelf;

/**
 * Class TestSingletonShelf
 *
 * @package axelitus\patterns\tests
 */
class TestSingletonShelf extends TestCase
{
    /**
     * @type SingletonShelf $shelf The singleton shelf instance.
     */
    protected $shelf;

    public function setUp()
    {
        $this->shelf = SingletonShelf\FooShelf::forge(new SingletonShelf\FooFactory());
    }

    public function test_grab()
    {
        $foo = $this->shelf->grab('foo');
        $this->assertEquals('foo', $foo->getValue());

        $foo2 = $this->shelf->grab('bar');
        $this->assertEquals('foo', $foo2->getValue());
    }
}

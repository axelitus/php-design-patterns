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
 * Class FactoryTests
 * @package axelitus\patterns\tests
 */
class FactoryTests extends TestCase
{
    /**
     * Tests the FooFactory
     */
    public function test_foo()
    {
        $factory = new Factory_FooFactory();
        $foo = $factory->produce();
        $this->assertTrue($foo instanceof src\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\Forgeable");
        $this->assertTrue($foo instanceof Factory_Foo, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Foo");
        $this->assertEquals('MyFoo', $foo->name, "The Foo's name is not 'MyFoo', it is '{$foo->name}'");

        $foo2 = $factory->produce('YourFoo');
        $this->assertTrue($foo2 instanceof src\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\Forgeable");
        $this->assertTrue($foo2 instanceof Factory_Foo, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Foo");
        $this->assertEquals('YourFoo', $foo2->name, "The Foo's name is not 'YourFoo', it is '{$foo2->name}'");
    }

    /**
     * Tests the BarFactory
     */
    public function test_bar()
    {
        $factory = new Factory_BarFactory();
        $bar = $factory->produce();
        $this->assertTrue($bar instanceof src\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\Forgeable");
        $this->assertTrue($bar instanceof Factory_Bar, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Bar");
        $this->assertEquals('MyBar', $bar->name, "The Bar's name is not 'MyBar', it is '{$bar->name}'");

        $bar2 = $factory->produce('YourBar');
        $this->assertTrue($bar2 instanceof src\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\Forgeable");
        $this->assertTrue($bar2 instanceof Factory_Bar, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Bar");
        $this->assertEquals('YourBar', $bar2->name, "The Bar's name is not 'YourBar', it is '{$bar2->name}'");
    }

    /**
     * Tests the FooBarFactory
     */
    public function test_foobar()
    {
        $factory = new Factory_FooBarFactory();
        $foobar = $factory->produce('Bar', 'NewBar');
        $this->assertTrue($foobar instanceof src\Forgeable, "The object \$foobar is not an instance of axelitus\\patterns\\Forgeable");
        $this->assertTrue($foobar instanceof Factory_Bar, "The object \$foobar is not an instance of axelitus\\patterns\\tests\\Factory_Bar");
        $this->assertEquals('NewBar', $foobar->name, "The Bar's name is not 'NewBar', it is '{$foobar->name}'");
    }
}
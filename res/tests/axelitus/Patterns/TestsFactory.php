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
        $this->assertTrue($foo instanceof Interfaces\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\interfaces\Forgeable but it should.");
        $this->assertTrue($foo instanceof Factory_Foo, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Foo but it should.");
        $this->assertEquals('MyFoo', $foo->name, "The Foo's name is not 'MyFoo', it is '{$foo->name}'");

        $foo2 = $factory->produce('YourFoo');
        $this->assertTrue($foo2 instanceof Interfaces\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\interfaces\Forgeable but it should.");
        $this->assertTrue($foo2 instanceof Factory_Foo, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Foo but it should.");
        $this->assertEquals('YourFoo', $foo2->name, "The Foo's name is not 'YourFoo', it is '{$foo2->name}'");
    }

    /**
     * Tests the BarFactory
     */
    public function test_bar()
    {
        $factory = new Factory_BarFactory();
        $bar = $factory->produce();
        $this->assertTrue($bar instanceof Interfaces\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\interfaces\Forgeable but it should.");
        $this->assertTrue($bar instanceof Factory_Bar, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Bar but it should.");
        $this->assertEquals('MyBar', $bar->name, "The Bar's name is not 'MyBar', it is '{$bar->name}'");

        $bar2 = $factory->produce('YourBar');
        $this->assertTrue($bar2 instanceof Interfaces\Forgeable, "The object \$foo is not an instance of axelitus\\patterns\\interfaces\Forgeable but it should.");
        $this->assertTrue($bar2 instanceof Factory_Bar, "The object \$foo is not an instance of axelitus\\patterns\\tests\\Factory_Bar but it should.");
        $this->assertEquals('YourBar', $bar2->name, "The Bar's name is not 'YourBar', it is '{$bar2->name}'");
    }

    /**
     * Tests the FooBarFactory
     */
    public function test_foobar()
    {
        $factory = new Factory_FooBarFactory();
        $foobar = $factory->produce('Bar', 'NewBar');
        $this->assertTrue($foobar instanceof Interfaces\Forgeable, "The object \$foobar is not an instance of axelitus\\patterns\\interfaces\Forgeable but it should.");
        $this->assertTrue($foobar instanceof Factory_Bar, "The object \$foobar is not an instance of axelitus\\patterns\\tests\\Factory_Bar but it should.");
        $this->assertEquals('NewBar', $foobar->name, "The Bar's name is not 'NewBar', it is '{$foobar->name}'");
    }
}

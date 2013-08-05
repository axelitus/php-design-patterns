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
 * Class GenericMultitonTests
 * @package axelitus\patterns\tests
 */
class GenericMultitonTests extends TestCase
{
    /**
     * Tests the GenericMultiton simple behavior.
     */
    public function test_behavior()
    {
        $m1 = GenericMultiton_Concrete::instance();
        $this->assertTrue(
            $m1 instanceof GenericMultiton_ConcreteInstance,
            "The object \$m1 is not an instance of axelitus\\patterns\\tests\\GenericMultiton_ConcreteInstance but it should."
        );

        $m2 = GenericMultiton_Concrete::instance();
        $this->assertTrue(
            $m2 instanceof GenericMultiton_ConcreteInstance,
            "The object \$m2 is not an instance of axelitus\\patterns\\tests\\GenericMultiton_ConcreteInstance but it should."
        );
        $this->assertTrue($m1 === $m2, "The objects \$m1 and \$m2 are not the same instance but they should.");

        GenericMultiton_Concrete::kill();
        $m3 = GenericMultiton_Concrete::instance();
        $this->assertTrue(
            $m3 instanceof GenericMultiton_ConcreteInstance,
            "The object \$m3 is not an instance of axelitus\\patterns\\testes\\GenericMultiton_ConcreteInstance but it should."
        );
        $this->assertEquals(true, $m1 !== $m3, "The objects \$m1 and \$m3 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m3, "The objects \$m2 and \$m3 are the same instance but they should not.");

        $m4 = GenericMultiton_Concrete::reinstance();
        $this->assertTrue(
            $m4 instanceof GenericMultiton_ConcreteInstance,
            "The object \$m4 is not an instance of axelitus\\patterns\\testes\\GenericMultiton_ConcreteInstance but it should."
        );
        $this->assertEquals(true, $m1 !== $m4, "The objects \$m1 and \$m4 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m4, "The objects \$m2 and \$m4 are the same instance but they should not.");
        $this->assertEquals(true, $m3 !== $m4, "The objects \$m3 and \$m4 are the same instance but they should not.");
    }

    /**
     * Testes the GenericMultiton interfaces\Forgeable behavior.
     *
     * @depends test_behavior
     */
    public function test_forgeable()
    {
        $m1 = GenericMultiton_ConcreteForgeable::instance();
        $this->assertTrue(
            $m1 instanceof GenericMultiton_ConcreteForgeableInstance,
            "The object \$m1 is not an instance of axelitus\\patterns\\tests\\GenericMultiton_ConcreteForgeableInstance but it should."
        );

        $m2 = GenericMultiton_ConcreteForgeable::instance();
        $this->assertTrue(
            $m2 instanceof GenericMultiton_ConcreteForgeableInstance,
            "The object \$m2 is not an instance of axelitus\\patterns\\tests\\GenericMultiton_ConcreteForgeableInstance but it should."
        );
        $this->assertTrue($m1 === $m2, "The objects \$m1 and \$m2 are not the same instance but they should.");

        GenericMultiton_ConcreteForgeable::kill();
        $m3 = GenericMultiton_ConcreteForgeable::instance();
        $this->assertTrue(
            $m3 instanceof GenericMultiton_ConcreteForgeableInstance,
            "The object \$m3 is not an instance of axelitus\\patterns\\testes\\GenericMultiton_ConcreteForgeableInstance but it should."
        );
        $this->assertEquals(true, $m1 !== $m3, "The objects \$m1 and \$m3 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m3, "The objects \$m2 and \$m3 are the same instance but they should not.");

        $m4 = GenericMultiton_ConcreteForgeable::reinstance();
        $this->assertTrue(
            $m4 instanceof GenericMultiton_ConcreteForgeableInstance,
            "The object \$m4 is not an instance of axelitus\\patterns\\testes\\GenericMultiton_ConcreteForgeableInstance but it should."
        );
        $this->assertEquals(true, $m1 !== $m4, "The objects \$m1 and \$m4 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m4, "The objects \$m2 and \$m4 are the same instance but they should not.");
        $this->assertEquals(true, $m3 !== $m4, "The objects \$m3 and \$m4 are the same instance but they should not.");
    }

    /**
     * Tests the Multiton kill behavior.
     *
     * @depends test_behavior
     */
    public function test_kill()
    {
        $m1 = GenericMultiton_Concrete::instance();
        $m2 = GenericMultiton_Concrete::instance('second');
        $m3 = GenericMultiton_Concrete::instance('third');

        GenericMultiton_Concrete::kill('second');
        $m4 = GenericMultiton_Concrete::instance('second');
        $this->assertFalse($m2 === $m4, "The objects \$m2 and \$m4 are the same instance but they should not.");
    }

    /**
     * Tests the Multiton multiple behavior.
     *
     * @depends test_behavior
     * @depends test_forgeable
     */
    public function test_multiple()
    {
        $m1 = GenericMultiton_Concrete::instance();
        $m2 = GenericMultiton_Concrete::instance('other');
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");

        $m3 = GenericMultiton_Concrete::instance('other');
        $this->assertTrue($m2 === $m3, "The objects \$m2 and \$m3 are not the same instance but they should.");

        $m4 = GenericMultiton_ConcreteForgeable::instance();
        $m5 = GenericMultiton_ConcreteForgeable::instance('other');
        $this->assertFalse($m1 === $m4, "The objects \$m1 and \$m4 are the same instance but they should not.");
        $this->assertFalse($m2 === $m5, "The objects \$m2 and \$m5 are the same instance but they should not.");
    }

    /**
     * Tests the Multiton instances count.
     *
     * @depends test_behavior
     * @depends test_multiple
     */
    public function test_count()
    {
        GenericMultiton_Concrete::clear();
        $this->assertEquals(0, GenericMultiton_Concrete::count());

        $m1 = GenericMultiton_Concrete::instance();
        $this->assertEquals(1, GenericMultiton_Concrete::count());

        $m2 = GenericMultiton_Concrete::instance('second');
        $this->assertEquals(2, GenericMultiton_Concrete::count());

        $m3 = GenericMultiton_Concrete::instance('third');
        $this->assertEquals(3, GenericMultiton_Concrete::count());

        $m4 = GenericMultiton_Concrete::instance('fourth');
        $this->assertEquals(4, GenericMultiton_Concrete::count());

        GenericMultiton_Concrete::kill('second');
        $this->assertEquals(3, GenericMultiton_Concrete::count());

        GenericMultiton_Concrete::kill();
        $this->assertEquals(2, GenericMultiton_Concrete::count());

        GenericMultiton_Concrete::clear();
        $this->assertEquals(0, GenericMultiton_Concrete::count());
    }

    /**
     * Tests the Multiton inheritance isolation.
     *
     * @depends test_multiple
     */
    public function test_inheritance()
    {
        $m1 = GenericMultiton_Concrete::instance();
        $m2 = GenericMultiton_ConcreteForgeable::instance();
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");
    }
}
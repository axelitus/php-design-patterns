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
 * Class MultitonTests
 * @package axelitus\patterns\tests
 */
class MultitonTests extends TestCase
{
    /**
     * Tests the Multiton simple behavior.
     */
    public function test_behavior()
    {
        $m1 = Multiton_Concrete::instance();
        $this->assertTrue(
            $m1 instanceof src\Multiton,
            "The object \$m1 is not an instance of axelitus\\patterns\\Multiton but it should."
        );
        $this->assertTrue(
            $m1 instanceof Multiton_Concrete,
            "The object \$m1 is not an instance of axelitus\\patterns\\tests\\Multiton_Concrete but it should."
        );

        $m2 = Multiton_Concrete::instance();
        $this->assertTrue(
            $m2 instanceof src\Multiton,
            "The object \$m2 is not an instance of axelitus\\patterns\\Multiton but it should."
        );
        $this->assertTrue(
            $m2 instanceof Multiton_Concrete,
            "The object \$m2 is not an instance of axelitus\\patterns\\tests\\Multiton_Concrete but it should."
        );
        $this->assertTrue($m1 === $m2, "The objects \$m1 and \$m2 are not the same instance but they should.");

        Multiton_Concrete::kill();
        $m3 = Multiton_Concrete::instance();
        $this->assertTrue(
            $m3 instanceof src\Multiton,
            "The object \$m3 is not an instance of axelitus\\patterns\\Multiton but it should."
        );
        $this->assertTrue(
            $m3 instanceof Multiton_Concrete,
            "The object \$m3 is not an instance of axelitus\\patterns\\tests\\Multiton_Concrete but it should."
        );
        $this->assertEquals(true, $m1 !== $m3, "The objects \$m1 and \$m3 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m3, "The objects \$m2 and \$m3 are the same instance but they should not.");

        $m4 = Multiton_Concrete::reinstance();
        $this->assertTrue(
            $m4 instanceof src\Multiton,
            "The object \$m4 is not an instance of axelitus\\patterns\\Multiton but it should."
        );
        $this->assertTrue(
            $m4 instanceof Multiton_Concrete,
            "The object \$m4 is not an instance of axelitus\\patterns\\tests\\Multiton_Concrete but it should."
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
        $m1 = Multiton_Concrete::instance();
        $m2 = Multiton_Concrete::instance('second');
        $m3 = Multiton_Concrete::instance('third');

        Multiton_Concrete::kill('second');
        $m4 = Multiton_Concrete::instance('second');
        $this->assertFalse($m2 === $m4, "The objects \$m2 and \$m4 are the same instance but they should not.");
    }

    /**
     * Tests the Multiton multiple behavior.
     *
     * @depends test_behavior
     */
    public function test_multiple()
    {
        $m1 = Multiton_Concrete::instance();
        $m2 = Multiton_Concrete::instance('other');
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");

        $m3 = Multiton_Concrete::instance('other');
        $this->assertTrue($m2 === $m3, "The objects \$m2 and \$m3 are not the same instance but they should.");

        $m4 = Multiton_Concrete2::instance();
        $m5 = Multiton_Concrete2::instance('other');
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
        // As we are working with static data, manually ensure we start with an empty Multiton array
        Multiton_Concrete::clear();
        Multiton_Concrete2::clear();

        $this->assertEquals(0, Multiton_Concrete::count());

        $m1 = Multiton_Concrete::instance();
        $this->assertEquals(1, Multiton_Concrete::count());

        $m2 = Multiton_Concrete::instance('second');
        $this->assertEquals(2, Multiton_Concrete::count());

        $m3 = Multiton_Concrete::instance('third');
        $this->assertEquals(3, Multiton_Concrete::count());

        $m4 = Multiton_Concrete::instance('fourth');
        $this->assertEquals(4, Multiton_Concrete::count());
        $this->assertEquals(0, Multiton_Concrete2::count());

        Multiton_Concrete::kill('second');
        $this->assertEquals(3, Multiton_Concrete::count());

        Multiton_Concrete::kill();
        $this->assertEquals(2, Multiton_Concrete::count());

        Multiton_Concrete::clear();
        $this->assertEquals(0, Multiton_Concrete::count());
    }

    /**
     * Tests the Multiton inheritance isolation.
     *
     * @depends test_multiple
     */
    public function test_inheritance()
    {
        $m1 = Multiton_Concrete::instance();
        $m2 = Multiton_Concrete2::instance();
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");
    }
}
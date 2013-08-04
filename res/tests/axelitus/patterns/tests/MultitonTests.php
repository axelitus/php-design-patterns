<?php
/**
 * Part of the axelitus\patterns package.
 *
 * @package     axelitus\patterns\test
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/patterns
 * @source      https://github.com/axelitusdev/patterns
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
        $m1 = MultitonConcrete::instance();
        $this->assertTrue(
            $m1 instanceof src\Multiton,
            "The object \$m1 is not an instance of axelitus\\patterns\\Multiton"
        );
        $this->assertTrue(
            $m1 instanceof MultitonConcrete,
            "The object \$m1 is not an instance of axelitus\\patterns\\tests\\MultitonConcrete"
        );

        $m2 = MultitonConcrete::instance();
        $this->assertTrue(
            $m2 instanceof src\Multiton,
            "The object \$m2 is not an instance of axelitus\\patterns\\Multiton"
        );
        $this->assertTrue(
            $m2 instanceof MultitonConcrete,
            "The object \$m2 is not an instance of axelitus\\patterns\\tests\\MultitonConcrete"
        );
        $this->assertTrue($m1 === $m2, "The objects \$m1 and \$m2 are not the same instance but they should.");

        MultitonConcrete::kill();
        $m3 = MultitonConcrete::instance();
        $this->assertTrue(
            $m3 instanceof src\Multiton,
            "The object \$m3 is not an instance of axelitus\\patterns\\Multiton"
        );
        $this->assertTrue(
            $m3 instanceof MultitonConcrete,
            "The object \$m3 is not an instance of axelitus\\patterns\\tests\\MultitonConcrete"
        );
        $this->assertEquals(true, $m1 !== $m3, "The objects \$m1 and \$m3 are the same instance but they should not.");
        $this->assertEquals(true, $m2 !== $m3, "The objects \$m2 and \$m3 are the same instance but they should not.");

        $m4 = MultitonConcrete::reinstance();
        $this->assertTrue(
            $m3 instanceof src\Multiton,
            "The object \$m3 is not an instance of axelitus\\patterns\\Multiton"
        );
        $this->assertTrue(
            $m3 instanceof MultitonConcrete,
            "The object \$m3 is not an instance of axelitus\\patterns\\tests\\MultitonConcrete"
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
        $m1 = MultitonConcrete::instance();
        $m2 = MultitonConcrete::instance('second');
        $m3 = MultitonConcrete::instance('third');

        MultitonConcrete::kill('second');
        $m4 = MultitonConcrete::instance('second');
        $this->assertFalse($m2 === $m4, "The objects \$m2 and \$m4 are the same instance but they should not.");
    }

    /**
     * Tests the Multiton multiple behavior.
     *
     * @depends test_behavior
     */
    public function test_multiple()
    {
        $m1 = MultitonConcrete::instance();
        $m2 = MultitonConcrete::instance('other');
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");

        $m3 = MultitonConcrete::instance('other');
        $this->assertTrue($m2 === $m3, "The objects \$m2 and \$m3 are not the same instance but they should.");

        $m4 = MultitonConcrete2::instance();
        $m5 = MultitonConcrete2::instance('other');
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
        MultitonConcrete::clear();
        $this->assertEquals(0, MultitonConcrete::count());

        $m1 = MultitonConcrete::instance();
        $this->assertEquals(1, MultitonConcrete::count());

        $m2 = MultitonConcrete::instance('second');
        $this->assertEquals(2, MultitonConcrete::count());

        $m3 = MultitonConcrete::instance('third');
        $this->assertEquals(3, MultitonConcrete::count());

        $m4 = MultitonConcrete::instance('fourth');
        $this->assertEquals(4, MultitonConcrete::count());

        MultitonConcrete::kill('second');
        $this->assertEquals(3, MultitonConcrete::count());

        MultitonConcrete::kill();
        $this->assertEquals(2, MultitonConcrete::count());

        MultitonConcrete::clear();
        $this->assertEquals(0, MultitonConcrete::count());
    }

    /**
     * Tests the Multiton inheritance isolation.
     *
     * @depends test_multiple
     */
    public function test_inheritance()
    {
        $m1 = MultitonConcrete::instance();
        $m2 = MultitonConcrete2::instance();
        $this->assertFalse($m1 === $m2, "The objects \$m1 and \$m2 are the same instance but they should not.");
    }
}
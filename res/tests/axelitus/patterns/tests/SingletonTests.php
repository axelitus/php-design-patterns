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
 * Class SingletonTests
 * @package axelitus\patterns\tests
 */
class SingletonTests extends TestCase
{
    /**
     * Tests the Singleton simple behavior.
     */
    public function test_behavior()
    {
        $s1 = Singleton_Concrete::instance();
        $this->assertTrue($s1 instanceof src\Singleton, "The object \$s1 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s1 instanceof Singleton_Concrete, "The object \$s1 is not an instance of axelitus\\patterns\\tests\\Singleton_Concrete");

        $s2 = Singleton_Concrete::instance();
        $this->assertTrue($s2 instanceof src\Singleton, "The object \$s2 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s2 instanceof Singleton_Concrete, "The object \$s2 is not an instance of axelitus\\patterns\\tests\\Singleton_Concrete");
        $this->assertTrue($s1 === $s2, "The objects \$s1 and \$s2 are not the same instance but they should.");

        Singleton_Concrete::kill();
        $s3 = Singleton_Concrete::instance();
        $this->assertTrue($s3 instanceof src\Singleton, "The object \$s3 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s3 instanceof Singleton_Concrete, "The object \$s3 is not an instance of axelitus\\patterns\\tests\\Singleton_Concrete");
        $this->assertFalse($s1 === $s3, "The objects \$s1 and \$s3 are the same instance but they should not.");
        $this->assertFalse($s2 === $s3, "The objects \$s2 and \$s3 are the same instance but they should not.");

        $s4 = Singleton_Concrete::reinstance();
        $this->assertTrue($s3 instanceof src\Singleton, "The object \$s3 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s3 instanceof Singleton_Concrete, "The object \$s3 is not an instance of axelitus\\patterns\\tests\\Singleton_Concrete");
        $this->assertFalse($s1 === $s4, "The objects \$s1 and \$s4 are the same instance but they should not.");
        $this->assertFalse($s2 === $s4, "The objects \$s2 and \$s4 are the same instance but they should not.");
        $this->assertFalse($s3 === $s4, "The objects \$s3 and \$s4 are the same instance but they should not.");
    }

    /**
     * Tests the Singleton inheritance isolation.
     *
     * @depends test_behavior
     */
    public function test_inheritance()
    {
        $s1 = Singleton_Concrete::instance();
        $s2 = Singleton_Concrete2::instance();
        $this->assertFalse($s1 === $s2, "The objects \$s1 and \$s2 are the same instance but they should not.");
    }
}
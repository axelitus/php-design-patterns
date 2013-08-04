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
 * Class SingletonTests
 * @package axelitus\patterns\tests
 */
class SingletonTests extends TestCase
{
    public function test_behavior()
    {
        $s1 = SingletonConcrete::instance();
        $this->assertTrue($s1 instanceof src\Singleton, "The object \$s1 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s1 instanceof SingletonConcrete, "The object \$s1 is not an instance of axelitus\\patterns\\tests\\SingletonConcrete");

        $s2 = SingletonConcrete::instance();
        $this->assertTrue($s2 instanceof src\Singleton, "The object \$s2 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s2 instanceof SingletonConcrete, "The object \$s2 is not an instance of axelitus\\patterns\\tests\\SingletonConcrete");

        $this->assertEquals(true, $s1 === $s2, "The objects \$s1 and \$s2 are not the same instance.");

        SingletonConcrete::kill();
        $s3 = SingletonConcrete::instance();
        $this->assertTrue($s3 instanceof src\Singleton, "The object \$s3 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s3 instanceof SingletonConcrete, "The object \$s3 is not an instance of axelitus\\patterns\\tests\\SingletonConcrete");

        $this->assertEquals(true, $s1 !== $s3, "The objects \$s1 and \$s3 are the same instance.");
        $this->assertEquals(true, $s2 !== $s3, "The objects \$s2 and \$s3 are the same instance.");

        $s4 = SingletonConcrete::reinstance();
        $this->assertTrue($s3 instanceof src\Singleton, "The object \$s3 is not an instance of axelitus\\patterns\\Singleton");
        $this->assertTrue($s3 instanceof SingletonConcrete, "The object \$s3 is not an instance of axelitus\\patterns\\tests\\SingletonConcrete");
        $this->assertEquals(true, $s1 !== $s4, "The objects \$s1 and \$s4 are the same instance.");
        $this->assertEquals(true, $s2 !== $s4, "The objects \$s2 and \$s4 are the same instance.");
        $this->assertEquals(true, $s3 !== $s4, "The objects \$s3 and \$s4 are the same instance.");
    }
}
<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests;

use axy\sourcemap\SourceMap;
use axy\sourcemap\parsing\FormatChecker;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class SourceMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getData
     * @return \axy\sourcemap\SourceMap
     */
    public function testCreate()
    {
        $map = new SourceMap();
        $this->assertEquals(['version' => 3], $map->getData());
        $this->setExpectedException('axy\sourcemap\errors\InvalidFormat');
        return new SourceMap(['version' => 5]);
    }

    public function testPropertyVersion()
    {
        $map = new SourceMap();
        $this->assertSame(3, $map->version);
        $this->assertTrue(isset($map->version));
        $map->version = 3;
        $map->version = '3';
        $this->assertSame(3, $map->version);
        $this->setExpectedException('axy\sourcemap\errors\UnsupportedVersion');
        $map->version = 5;
    }

    /**
     * covers ::__get
     * @expectedException \axy\errors\FieldNotExist
     */
    public function testMagicGet()
    {
        $map = new SourceMap();
        return $map->abc;
    }

    /**
     * covers ::__set
     * @expectedException \axy\errors\FieldNotExist
     */
    public function testMagicSet()
    {
        $map = new SourceMap();
        $map->abc = 1;
    }

    /**
     * covers ::__unset
     * @expectedException \axy\errors\ContainerReadOnly
     */
    public function testMagicUnset()
    {
        $map = new SourceMap();
        unset($map->version);
    }

    public function testMagicIsset()
    {
        $map = new SourceMap();
        $this->assertFalse(isset($map->abc));
    }
}
